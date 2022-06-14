<?php

namespace App\Modules\Users\Http\Repositories\User;

use App\Modules\Users\Http\Repositories\CoreRepository;
use App\Modules\Users\Models\User;
use DB;

class UsersRepository extends CoreRepository
{
	public function __construct()
	{
	    parent::__construct();
	}

    protected function getModel()
    {
        return new User;
    }
}