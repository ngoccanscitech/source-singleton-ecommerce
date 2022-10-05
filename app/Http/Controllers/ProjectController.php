<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page as Page;
use App\Model\Project;
use App\Model\CategoryProject;
use Illuminate\Support\Facades\View;
use Gornymedia\Shortcodes\Facades\Shortcode;

class ProjectController extends Controller {
    use \App\Traits\LocalizeController;
    
    public $data = [];

    public function index($slug) {
        $this->localized();
        $page = Page::where('slug', $slug)->first();
        $this->data['page'] = $page;

        $this->data['projects'] = Project::where('status', 0)->orderByDesc('id')->paginate(20);

        $templateName = 'theme.'.$page->template.'.index';
        if (View::exists($templateName))
            return view($templateName, ['data' => $this->data])->compileShortcodes();
        else
            return redirect(url('/'));
    }

    public function detail($slug, $id){
        $this->localized();
        $this->data['project'] = Project::find($id);
        $this->data['news_featured'] = Project::orderbyDesc('id')->limit(3)->get();
        return view('theme.project.detail', ['data'=> $this->data]);
    }
    
    public function category($slug){

        $this->localized();
        $this->data['category'] = \App\Model\CategoryProject::all();
        $this->data['current'] = \App\Model\CategoryProject::where('slug', $slug)->first();
        // $this->data['page'] = $this->data['current'];
        $this->data['projects'] = $this->data['current']->project()->where('status', 0)->paginate(12);
        return view('theme.project.index', ['data'=> $this->data]);
    }

}
