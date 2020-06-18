<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Click;
use App\Page;
use App\LinkClick;
use App\ScreenTime;
class ClickController extends Controller
{
    public function action(Request $request){
        \Log::info($request->page);
        $page = Page::where("page_url",$request->page)->first();
        // \Log::info( $page->id );
        \Log::info( $request->device );
        $y_axis_rasio = ($request->y_cord/$request->max_height) * 100;
        $x_axis_rasio = ($request->x_cord/$request->max_width) * 100;

        Click::create([
            // "page_id"=> $page->id,
            "page_id"=> 1,
            "page_x"=> $x_axis_rasio,
            "page_y"=> $y_axis_rasio,
            "pc_tab_sp" => $request->device,
            "body_height" => $request->max_height,
            "body_width" => $request->max_width,
        ]);
    }
    public function link_action(Request $request){
        \Log::info($request->page);
        $page = Page::where("page_url",$request->page)->first();
        // \Log::info( $page->id );
        \Log::info( $request->device );
        // $y_axis_rasio = ($request->y_cord/$request->max_height) * 100;
        // $x_axis_rasio = ($request->x_cord/$request->max_width) * 100;

        LinkClick::create([
            // "page_id"=> $page->id,
            "page_id"=> 1,
            "link"=> $request->href,
            "device"=> $request->device,
        ]);
    }
    public function scroll_action(Request $request){
        \Log::info("reseive");
        \Log::info($request);

        $page = Page::where("page_url",'like','%'.$request->page.'%')->first();
        \Log::info( $page );
        \Log::info( $request->device );
        \Log::info( $request->data );
       
        foreach(json_decode($request->data) as $y_axis => $count){
            \Log::info( $y_axis );
            \Log::info( $count );
            ScreenTime::create([
                // "page_id"=> $page->id,
                "page_id"=> $page->id,
                "page_y"=> $y_axis,
                "pc_tab_sp" => $request->device,
            ]);
        }
        

    }
    public function heatmap(Request $request){
        \Log::info("aaa");
        // \Log::info($request->id);
        // $page = Page::where("page_url",$request->page)->first();
        // \Log::info( $page->id );
        $data = Click::where("page_id",$request->id)->where('pc_tab_sp',$request->device)->get()->toArray();
        // \Log::info($data);
        $i = 0;
        $a=array();
        $k= [];
        $cnt= [];
        $unique= [];

        foreach($data as $key => $val){
            // if($val["page_x"]){
                $a[$key]["x"]= ceil (($val["page_x"] * $request->max_width)/100); 
            // }
            // elseif($key == "page_y"){
                $a[$key]["y"]= ceil (($val["page_y"] * $request->max_height)/100) ; 
                // $a[$key]["index"]=$a[$key]["x"]."_".$a[$key]["y"];
            // $a[$key]["radius"]= 50;
            // $a[$key]["value"]= 1;
            // $i++;
            $x_y = $a[$key]["x"]."_".$a[$key]["y"];

            if(!in_array( $x_y ,$k) ){
                $k[] = $x_y;
                // $unique[$key]["cnt"] = 0;
                // $unique[$key]["x"] = $a[$key]["x"];
                // $unique[$key]["y"] = $a[$key]["y"];
                $unique[$x_y] = [ 
                    "x"=> $a[$key]["x"],
                    "y"=> $a[$key]["y"],
                    "cnt"=> 1
                ];
            }else{
                \Log::info("重複");
                \Log::info($unique[$x_y]);
                $unique[$x_y]["cnt"]++;
                // $unique[$key]["cnt"] += 1;
            }
            
            // \Log::info($val);
        }
        $result = [];
        foreach($unique as $val){
            $result[$i] = [
                "x"=> $val["x"],
                "y"=> $val["y"],
                "radius"=> $val["cnt"]*8,
                "value"=> $val["cnt"]*5,
                
            ];
            $i++;
        }
        \Log::info($unique);
        \Log::info($k);
        \Log::info($result);
        // $a['amount'] = $i;
        // \Log::info($a);
        return json_encode($result);
    }
    public function screen_time_heatmap(Request $request){
        \Log::info("screen_time_heatmap");
        // \Log::info($request->id);
        // $page = Page::where("page_url",$request->page)->first();
        // \Log::info( $page->id );
        $data = ScreenTime::where("page_id",$request->id)->where('pc_tab_sp',$request->device)->get()->toArray();

        $result= [];

        foreach($data as $key => $val){
            \Log::info($val["page_y"]);
            \Log::info(ceil($val["page_y"] * $request->max_height)) ; 
            $result[] = ceil($val["page_y"] * $request->max_height);

        }
        return json_encode($result);
    }
    
}
