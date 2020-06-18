<?php

namespace App\Http\Controllers;

use App\Site;
use App\Page;
use Illuminate\Http\Request;
use App\Http\Requests\SiteRequest;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Site::all();
        return view("site.index",compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("site.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SiteRequest $request)
    {
        
        $result = Site::create([
            "title"=>$request->title,
            "page_url"=>$request->page_url,
        ]);
        foreach($request->pages as $page){
            Page::create([
                "site_id"=>$result->id,
                "page_url"=>$request->page_url,
            ]);
        }

        // return redirect("site.create",300);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site)
    {
        // echo "<pre>";
        // var_dump(request()->input("device"));
        $list =[];
        $stored =[];

        if(request()->input("page")){
            $site->selected = Page::find(request()->input("page"));
        // }
        // // foreach($site->page as $i => $page){
        // if(request()->input("page")){
            if(request()->input("device") == "3"){
                $site->img = $site->selected->sp_screenshot_imp;
            }elseif(request()->input("device") == "2"){
                $site->img = $site->selected->tab_screenshot_imp;
            }else{
                $site->img = $site->selected->pc_screenshot_imp;
            }
            foreach($site->selected->link_click as $data){
                if(!in_array($data->link,$stored)){
                    $stored[] = $data->link;
                    $list[$data->link]['count'] =0;
                    $list[$data->link]["url"] = $data->link;
                    
                }else{
                    $list[$data->link]["count"] += 1;
                }
                // echo $data->link;
            } 

        }            
        // var_dump($site->img);
       
        
        // var_dump($list);
        // var_dump($site->selected->link_click);
               // $data = Site::find($site);
        return view("site.show",compact("site","list"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function edit(Site $site)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Site $site)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function destroy(Site $site)
    {
        //
    }
}
