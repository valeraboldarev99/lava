<?php

namespace App\Modules\Contacts\Http\Controllers;

use App\Modules\Contacts\Models\Contacts;
use App\Modules\AdminPanel\Http\Controllers\IndexController as Controller;

use App\Modules\Contacts\Mail\ContactsMail;
// use App\Modules\Settings\Facades\Settings;
// use App\Rules\ReCaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    public function getModel()
    {
        return new Contacts();
    }

    public function index()
    {
        return view('Contacts::index');
    }

    public function modal()
    {
        return view('Contacts::modal-contact');
    }

    public function modalForm(Request $request)
    {
        $requestArray = $request->all();
        $requestArray['phone'] = preg_replace('/\D/', '', $requestArray['phone']);

        $validator = Validator::make($requestArray, $this->getRulesModal(), $this->getMessages());

        if ($validator->fails()) {
            return response()->json([
                'state' => 'error',
                'view' => view('Contacts::_modal', ['old' => $requestArray])
                    ->withErrors($validator->errors())
                    ->render()
            ], 200);
        }
        $requestArray['ip'] = ip2long($request->ip());
        $requestArray['datetime'] = date('Y-m-d H:i:s');

        $entity = $this->getModel()->create($requestArray);

        // $this->sendMail($entity);

        return response()->json([
            'state' => 'success',
            'message' => trans('Contacts::index.success'),
        ]);
    }

    public function getRulesModal()
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required|max:65535',
        ];
    }

    public function store(Request $request)
    {
        $requestArray = $request->all();
        
        $validator = Validator::make($requestArray, $this->getRules(), $this->getMessages());

        if ($validator->fails()) {
            return redirect()->to(url()->previous())->withInput($requestArray)->withErrors($validator);
        }

        $requestArray['ip'] = ip2long($request->ip());
        $requestArray['datetime'] = date('Y-m-d H:i:s');
        
        $entity = $this->getModel()->create($requestArray);
        
        $this->sendMail($entity);

		return redirect()->back()->with('message', 'Данные обновлены');

    }

    public function getRules()
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required|max:65535',
            // 'g-recaptcha-response' => [new ReCaptcha],
        ];
    }

    public function getMessages()
    {
        return [
            'name' => trans('contacts::index.errors.name'),
            'email' => trans('contacts::index.errors.email'),
            'phone' => trans('contacts::index.errors.phone'),
            'message' => trans('contacts::index.errors.message'),
        ];
    }

    protected function sendMail($entity)
    {
        $emails = getSetting('contacts.emails');
        $emails = $emails ? explode(',', $emails) : [];

        foreach ($emails as $item) {
            try {
                Mail::to(trim($item))->send(new ContactsMail($entity));
            } catch (\Swift_TransportException $e) {}
        }
    }
}