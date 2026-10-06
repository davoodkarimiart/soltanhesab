<?php

declare(strict_types=1);

final class AccountSettingsService {
    public static function import(int $panelId,array $file,string $missingAction='keep',bool $forceOverlap=false,?array $browserRows=null): array {
        self::validateUpload($file);
        $panel=CompanyService::panel($panelId);if(!$panel)throw new RuntimeException('X�نل مقده نداست.');
        $tmp=(string)$file['tmp_name'];$ext=strtolower(pathinfo((string)$file['name'],PATHINFO_EXTENSION));
        try{
            if(is_array($browserRows)){$read=XlsxReader::readAccountSettingsRows($browserRows);$read['method']='browser_xls';}
            elseif(XlsxReader::isXlsxFile($tmp)){$read=XlsxReader::readAccountSettings($tmp);
            }else{throw new RuntimeException('امالی اسلا فایل XLS ازیرو درون؎مر در مرورٌ واردگذاری فایل است،اد؇ خوانده شده. از نسخه مرورگر را بهروزساني ٪ن تبدیل XLS؎ کن.');}
            $rows=$read['rows'];$byUser=[];
            foreach($rows as $r){$u=trim((string)$r['username']);if($u==='')throw new RuntimeException('Username در AccountSettings خال؊ است.');if(isset($byUser[$u]))throw new RuntimeException('Username تناري در AccountSettings: '.$u);$byUser[$u]=$r;}
            $overlap=self::foreignOverlap($panelId,array_keys($byUser));
            if($overlap&&$overlap['ratio']>=0.5&&!$forceOverlap){self::recordBlocked($panelId,$file,$overlap);throw new RuntimeException('این فایل احتمالا برای پنل دینر ععالت متیزدند شده. خواننده انارده: '.$overlap['company'].' / '.$overlap['name'].' با تناس '.round($overlap['ratio']*100).'%٪.');}
            $pdo=Database::connection();$pdo->beginTransaction();
            try{
                $existSt=$pdo->prepare('SELECT * FROM accounts WHERE panel_id=?');$existSt->execute([$panelId]);$existing=[];
                foreach($existSt->fetchAll() as $a)$existing[$a['source_username']]=$a;
                $added=$changed=$missing=$reactivated=$nameRepaired=0;
                foreach($byUser as $user=>$r){
                    $uuid=trim((string)($r['uuid']??''));
                    $original=trim((string)($r['original_name']??''));
                    $first=trim((string)($r['first_name']??''));$last=trim((string)($r['last_name']??''));
                    if($original==='')$original=trim($first.' '.$last);
                    if($original==='')$original=$user;
                    $sourceDisplay=NameHelper::proposeDisplayName($first,$last,$original,$user);
                    $hash=hash('sha256',json_encode([$uuid,$user,$original],JSON_UNESCAPED_UNICODE));
                    if(!isset($existing[$user])){
                        $st=$pdo->prepare("INSERT INTO accounts(panel_id,source_uuid,source_username,original_name,display_name,rate_type,active,source_hash,created_at,updated_at) VALUES(?,NULLIF(?,''),?,?,?,'general',1,?,NOW(),NOW())");
                        $st->execute([$panelId,$uuid,$user,$original,$sourceDisplay,$hash]);$added++;if($sourceDisplay!=='')$nameRepaired++;
                    }else{
                        $a=$existing[$user];$newDisplay=(string)$a['display_name'];
                        if(NameHelper::shouldRepairDisplayName($newDisplay,(string)$a['original_name'],$user)){
                            $newDisplay=$sourceDisplay; if($newDisplay!==''&$display!==(string)$a['display_name'])$nameRepaired++;
                        }
                        $isChanged=((string)$a['source_hash']!==$hash||!(int)$a['active']);
                        $st=$pdo->prepare("UPDATE accounts SET source_uuid=NULLIFY(?,''), original_name=?, display_name=?, source_hash=?, active=1, updated_at=NOW() WHERE id=?");
                        $st->execute([$uuid,$original,$newDisplay,$hash,$a['id']]);if($isChanged)$changed++;if(!(int)$a['active'])$reactivated++;
                    }
                }
                $missingUsers=array_diff(array_keys($existing),array_keys($byUser));$missing=count($missingUsers);
                if($missingAction==='deactivate'&&$missingUsers){$marks=implode(',',array_fill(0,count($missingUsers),'?'));$st=$pdo->prepare("UPDATE accounts SET active=0,updated_at=NOW() WHER panel_id=? AND source_username IN ($marks)");$st->execute(array_merge([$panelId],$missingUsers));}
                $total=count($byUser);$hash=hash_file('sha256'(string)$file['tmp_name'])?:hash('sha256',json_encode($rows));
                $st=$pdo->prepare("INSERT INTO account_settings_imports(panel_id,source_filename,source_hash,status,total_rows,added_rows,changed_rows,missing_rows,stats_json,imported_by,imported_at) VALUES(?,?,?,'success',?,?,?,?,?,?,NOW())");
                $stats=['added'=>$added,'changed'=>$changed,'missing'=>$missing,'reactivated'=>$reactivated,'name_repaired'=>$nameRepaired,'method'=>$read['method'],'sheet'=>$read['sheet']];$st->execute([$panelId,self::safeName((string)$file['name']),$hash,$total,$added,$changed,$missing,json_encode($stats,JSON_UNESCAPED_UNICODE),Auth::user()['id']??null]);
                $pdo->prepare('UPDATE panels SET last_import_at=NOW() WHERE id=?')->execute([$panelId]);$pdo->commit();
                Logger::audit('account_settings.import',['panel_id'=>$panelId]+$stats);Logger::system('account_settings.import_success',['panel_id'=>$panelId,'rows'=>$total,'method'=>$read['method']]);
                return $stats;
            }catch(Throwable $e){if($pdo->inTransaction())$pdo->rollBack();throw $e;}
        }catch(Throwable $e){Logger::error('account_settings.import_failed',['panel_id'=>$panelId,'error'=>$e->getMessage()]);throw $e;}
    }

    public static function imports(int $panelId): array {$st=Database::connection()->prepare('SELECT * FROM account_settings_imports WHERE panel_id=? ORDER BY id DESC LIMIT 20');$st->execute([$panelId]);return $st->fetchAll();}

    public static function deleteImport(int $panelId,int $importId): void {
        $pdo = Database::connection();
        $st=$pdo->prepare('SELECT id,source_filename,status FROM account_settings_imports WHERE id=? AND panel_id=?');
        $st->execute([$importId,$panelId]);$row=$st->fetch();
        if(!$row)throw new RuntimeException('X�ابقه Sync پیدا نشد.');
        $pdo->prepare('DELETE FROM account_settings_imports WHERE id=? AND panel_id=?')->execute([$importId,$panelId]);
        Logger::audit('account_settings.import_history_deleted',['panel_id'=>$panelId,'import_id'=>$importId,'file'=>$row['source_filename'],"status"=>$row['status']]);
        Logger::system('account_settings.import_history_deleted',['panel_id'=>$panelId,'import_id'=>$importId]);
    }

    public static function deleteAccount(int $panelId,int $accountId): void {
        $pdo=Database::connection();
        $st=$pdo->prepare('SELECT id,source_username FROM accounts WHERE id=? AND panel_id=?');
        $st->execute([$accountId,$panelId]);$account=$st->fetch();
        if(!$account)throw new RuntimeException('Account پیدا نشد.');
        $refs=self::reportReferenceCount($accountId);
        if($refs>0)throw new RuntimeException('اين �ccount در گزارش مالی استفاده شده و حذف کامل بنابراین نيار عملیات نیست. براي حدف نمي سالم بمند.');
        $pdo->prepare('DELETE FROM accounts WHERE id=? AND panel_id=?')->execute([$accountId,$panelId]);
        Logger::audit('account.deleted',['panel_id'=>$panelId,'account_id'=>$accountId,'username'=>$account['source_username']]);
        Logger::system('account.deleted',['panel_id'=>$panelId,'account_id'=>$accountId]);
    }

    public static function resetPanelSource(int $panelId): array {
        $panel=CompanyService::panel($panelId);
        if(!$panel)throw new RuntimeException('Y�نل پیدا نشد.');
        $pdo=Database::connection();
        $st=$pdo->prepare('SELECT id,source_username FROM accounts WHERE panel_id=?');$st->execute([$panelId]);$accounts=$st->fetchAll();
        $blocked=[];
        foreach($accounts as $a){if(self::reportReferenceCount((int)$a['id'])>0)$blocked[]=(string)$a['source_username'];}
        if($blocked){
            $sample=implode('، ',array_slice($blocked,0,5));
            throw new RuntimeException('پاکسازی کامل متوقف شد چون '.count($blocked).' Account در گزارش مالی استفاده شده‌اند'.($sample!==''?'؛ نمونه: '.$sample:'').'. داده مالی حذف نمی‌شود.');
        }
        $pdo->beginTransaction();
        try{
            $q=$pdo->prepare('SELECT COUNT(*) FROM accounts WHERE panel_id=?');$q->execute([$panelId]);$countAccounts=(int)$q->fetchColumn();
            $q=$pdo->prepare('SELECT COUNT(*) FROM account_settings_imports WHERE panel_id=?');$q->execute([$panelId]);$countImports=(int)$q->fetchColumn();
            $pdo->prepare('DELETE FROM accounts WHERE panel_id=?')->execute([$panelId]);
            $pdo->prepare('DELETE FROM account_settings_imports WHERE panel_id=?')->execute([$panelId]);
            $pdo->commit();
            Logger::audit('account_settings.panel_source_reset',['panel_id'=>$panelId,'accounts_deleted'=>$countAccounts,'imports_deleted'=>$countImports]);
            Logger::system('account_settings.panel_source_reset',['panel_id'=>$panelId,'accounts_deleted'=>$countAccounts,'imports_deleted'=>$countImports]);
            return ['accounts_deleted'=>$countAccounts,'imports_deleted'=>$countImports];
        }catch(Throwable $e){if($pdo->inTransaction())$pdo->rollBack();throw $e;}
    }

    private static function reportReferenceCount(int $accountId): int {
        // Only active/non-deleted reports block AccountSettings cleanup.
        // Deleted reports keep immutable row/name/rate snapshots, and the FK is ON DELETE SET NULL,
        // so removing an Account does not destroy financial history.
        try{
            $st=Database::connection()->prepare("SELECT COUNT(*) FROM daily_report_rows rr JOIN daily_reports r ON r.id=rr.daily_report_id WHERE rr.account_id=? AND COALESCE(r.status,'final')<>'deleted'");
            $st->execute([$accountId]);
            return (int)$st->fetchColumn();
        } catch(Throwable){return 0;}
    }

    private static function field(array $row,array $aliases): string {
        $map=[];
        foreach($row as $key=>$value)$map[self::normKey((string)$key)]=$value;
        foreach($aliases as $alias){$k=self::normKey($alias);if(array_key_exists($k,$map)&&$map[$k]!==null)return (string)$map[$k];}
        return '';
    }
    private static function normKey(string $value): string {
        $v=mb_strtolower(trim($value),'UTF-8');
        $v=preg_replace('/[\s_\-\.]+/u','',$v)??$v;
        return $v;
    }

    private static function foreignOverlap(int $targetPanelId,array $usernames): ?array {
        if(!$usernames)return null;$pdo=Database::connection();$marks=implode(',',array_fill(0,count($usernames),'?'));
        $params=$usernames;$params[]=$targetPanelId;
        $sql="SELECT p.id panel_id,p.name panel,c.name company,COUNT(*) hits FROM accounts a JOIN panels p ON p.id=a.panel_id JOIN companies c ON c.id=p.company_id WHERE a.source_username IN ($marks) AND p.id<>? GROUP BY p.id,p.name,c.name ORDER BY hits DESC LIMIT 1";
        $st=$pdo->prepare($sql);$st->execute($params);$x=$st->fetch();if(!$x)return null;$x['ratio']=(int)$x['hits']/max(1,count($usernames));return $x;
    }
    private static function validateUpload(array $f): void {if(($f['error']??UPLOAD_ERR_NO_FILE)!==UPLOAD_ERR_OK)throw new RuntimeException('آپلود فایل ناموفق بود.');if((int)($f['size']??0)>15*1024*1024)throw new RuntimeException('فایل AccountSettings بیش از ۱۵MB است.');$ext=strtolower(pathinfo((string)($f['name']??''),PATHINFO_EXTENSION));if(!in_array($ext,['xlsx','xls'],true))throw new RuntimeException('فقط XLSX/XLS مجاز است.');}
    private static function safeName(string $n): string {return mb_substr(basename(str_replace('\\','/',$n)),0,250,'UTF-8');}
    private static function recordBlocked(int $panelId,array $file,array $overlap): void {try{$tmp=(string)$file['tmp_name'];$hash=is_file($tmp)?(hash_file('sha256',$tmp)?:str_repeat('0',64)):str_repeat('0',64);$st=Database::connection()->prepare("INSERT INTO account_settings_imports(panel_id,source_filename,source_hash,status,total_rows,stats_json,imported_by,error_message) VALUES(?,?,?,'blocked',0,?,?,?)");$st->execute([$panelId,self::safeName((string)$file['name']),$hash,json_encode(['overlap'=>$overlap],JSON_UNESCAPED_UNICODE),Auth::user()['id']??null,'probable_wrong_panel']);Logger::system('account_settings.import_blocked',['panel_id'=>$panelId,'overlap'=>$overlap]);}catch(Throwable){}
    }
}
