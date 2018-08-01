<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Requests\UpdateProfileFormRequest;

class UserController extends Controller
{   

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function profile()
    {
        return view('site.profile.profile');
    }


    public function profileUpdate(UpdateProfileFormRequest $request)
    {

        $dataForm = $request->all();

        if ($dataForm['password'] != null){
            
            $dataForm['password'] = bcrypt($dataForm['password']);
        }else{

            unset($dataForm['password']);

        }

        
        $user = $this->user->find(auth()->user()->id);
     
        $dataForm['image'] = $user->image; 
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            
            if ($user->image)
                $name = $user->image;
            else
            $name = $user->id.kebab_case($user->name);

            $extenstion = $request->image->extension();
            $nameFile = "{$name}.{$extenstion}";

            /***********************************
             *  
             * ABAIXO FICA O UPLOAD EM SI
             * 
             ***********************************/
            $dataForm['image'] = $nameFile;

            $upload = $request->image->storeAs('users', $nameFile);
            if(!$upload)

            return redirect()
                    ->back()
                    ->with('error', 'Erro ao carregar imagem');
        }

        $update = auth()->user()->update($dataForm);

        if ($update)
            return redirect()
            ->route('profile')
            ->with('success', 'Sucesso ao Ataulziar perfil');


        return redirect()
            ->back()
            ->with('error', 'Erro ao Ataulziar perfil');

    }

}
