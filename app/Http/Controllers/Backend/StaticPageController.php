<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $route = null)
    {
        $staticPages = StaticPage::whereIn('page', [StaticPage::COOKIES, StaticPage::LEGAL, StaticPage::TERMS_AND_CONDITIONS])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('backend.landing_page.table_static_pages', [
            'staticPages' => $staticPages,
            'route' => $route,
        ])->withErrors('Oops! no existe registro para mostrar');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($route = null)
    {
        return view('backend.forms.forms_static_page', [
            'route' => $route
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (empty($request->body)) {
            return response()->json(['status' => 'fail', 'alert' => 'Por favor, ingrese el contenido']);
        }


        $staticPage = StaticPage::where('title', '=', strtoupper($request->title))->first();
        if ($staticPage instanceof StaticPage) {
            return response()->json(['status' => 'fail', 'alert' => 'El registro ya existe']);
        }


        StaticPage::saveStaticPage($request);

        return response()->json(['status' => 'success', 'alert' => config('app.alert_success')]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\StaticPages $StaticPages
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $staticPages = StaticPage::where([
            ['page', '=', $request->page]
        ])->where('status', '=', StaticPage::STATIC_PAGE_ACTIVE)->first();

        $viewsStatic = StaticPage::TERMS_AND_CONDITIONS;

        if (!$staticPages instanceof StaticPage) {
            return redirect()->route('principal');
        }

        #Terminos y condiciones
        if ($request->page == StaticPage::TERMS_AND_CONDITIONS) {
            $viewsStatic = 'terms_and_conditions';
        }
        ##Politica de cookies
        if ($request->page == StaticPage::COOKIES) {
            $viewsStatic = 'cookies';
        }
        #Legal
        if ($request->page == StaticPage::LEGAL) {
            $viewsStatic = 'legal';
        }


        return view("frontend/$viewsStatic", ['staticPages' => $staticPages]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\StaticPages $StaticPages
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $route = null)
    {
        $data = StaticPage::find($id);

        return view('backend.forms.forms_static_page', [
            'data' => $data,
            'route' => $route
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\StaticPages $StaticPages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        if (empty($request->body)) {
            return response()->json(['status' => 'fail', 'alert' => 'Por favor, ingrese el contenido']);
        }

        $staticPage = StaticPage::where([['title', '=', strtoupper($request->title)], ['id', '!=', $request->id]])->first();
        if ($staticPage instanceof StaticPage) {
            return response()->json(['status' => 'fail', 'alert' => 'El registro ya existe']);
        }

        $staticPage = StaticPage::updateStaticPage($request);

        if ($staticPage) {
            return response()->json(['status' => 'success', 'alert' => config('app.alert_success')]);
        }

        return response()->json(['status' => 'success', 'alert' => config('app.alert_fail')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\StaticPages $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $staticPage = StaticPage::deleteStaticPage($request->id);

        if ($staticPage) {
            return response()->json(['status' => 'success', 'alert' => config('app.alert_success')]);
        }

        return response()->json(['status' => 'success', 'alert' => config('app.alert_fail')]);
    }
}
