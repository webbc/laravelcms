<?php

namespace App\Http\ViewComposers;

use App\Libs\CommonUtils;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminComposer {

    private $data = null;

    public function __construct(Request $request) {
        $this->data = new CommonUtils($request);
    }

    public function compose(View $view) {
        $view->with([
            'admin' => $this->data->admin,
            'mbx' => $this->data->mbx,
            'menu' => $this->data->menu,
            'msg' => $this->data->msg
        ]);
    }
}