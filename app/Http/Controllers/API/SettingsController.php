<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;
use App\BackupSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use File;

use App\Events\SystemLog\SystemLogEvent;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->settingsValidation($request);
        $setting = Setting::create([
            'tax' => $request->tax,
        ]);

        $request->merge(['activity' => 'Update tax']);
        $request->merge(['activity_id' => $setting->id]);
        $request->merge(['details' => $setting]);

        event(new SystemLogEvent($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->settingsValidation($request);

        $settings = Setting::findOrFail($id);
        $settings->tax = $request->tax;

        $request->merge(['activity' => 'Update tax']);
        $request->merge(['activity_id' => $settings->id]);
        $request->merge(['details' => $settings]);

        event(new SystemLogEvent($request));

        $settings->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
    public function settingsFunc(){
        $setting = Setting::get();

        return $setting;
    }

    public function settingsValidation($request){
        return $this->validate($request,[
            'tax' => 'required'
        ],
        [
            'tax.required'    => 'Tax field is required.'
        ]
    );
    }
    public function loadBackup(){
        $backup_settings = DB::table('backup_settings')
            ->orderBy('id','desc')
            ->paginate(50);
        return $backup_settings;
    }
    public function download(){
        $carbon = new Carbon();
        $carbon->setTimezone('Asia/Manila');
        $date_name = $carbon->format('Y-m-d');
        $time_format = $carbon->format('H:i:s');

        $timeFormat = str_replace(':','',$time_format);
        $backup_name = 'skin-'.$date_name.'-'.$timeFormat.'.sql';
        $connection = mysqli_connect('127.0.0.1','root','MBtuR5bc7xkmtyCv','skin');
        $tables = array();
        $result = mysqli_query($connection,"SHOW TABLES");
        while($row = mysqli_fetch_row($result)){
        $tables[] = $row[0];
        }
        $return = '';
        foreach($tables as $table){
        $result = mysqli_query($connection,"SELECT * FROM ".$table);
        $num_fields = mysqli_num_fields($result);

        $return .= 'DROP TABLE '.$table.';';
        $row2 = mysqli_fetch_row(mysqli_query($connection,"SHOW CREATE TABLE ".$table));
        $return .= "\n\n".$row2[1].";\n\n";

        for($i=0;$i<$num_fields;$i++){
            while($row = mysqli_fetch_row($result)){
            $return .= "INSERT INTO ".$table." VALUES(";
            for($j=0;$j<$num_fields;$j++){
                $row[$j] = addslashes($row[$j]);
                if(isset($row[$j])){ $return .= '"'.$row[$j].'"';}
                else{ $return .= '""';}
                if($j<$num_fields-1){ $return .= ',';}
            }
            $return .= ");\n";
            }
        }
        $return .= "\n\n\n";
        }

        // $timeFormat = str_replace(':','',$time_format);
        $backupSettings =  BackupSetting::create([
            'backup_name' => $backup_name,
            'date' => $date_name,
            'time' => $timeFormat
        ]);

        $request = new \Illuminate\Http\Request();
        $request->merge(['activity' => 'Create backup']);
        $request->merge(['activity_id' => $backupSettings->id]);
        $request->merge(['details' => $backupSettings]);

        event(new SystemLogEvent($request));

        $backupSettings->save();

        $handle = fopen(public_path('backupsql/'.$backup_name.''),"w+");
        fwrite($handle,$return);
        fclose($handle);
    }
    public function downloadSql(Request $request){

        
        // $path= asset('dist/test/'.$request->filename);
        $path = public_path('backupsql/'.$request->filename.'');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $file = file_get_contents($path);

        $request->merge(['activity' => 'Download backup']);
        $request->merge(['activity_id' => $request->id]);
        $request->merge(['details' => $request->filename]);

        event(new SystemLogEvent($request));

        return $file;
    }

}
