<?php

namespace App\Abstract\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

abstract class ResourceController extends BaseController {
  abstract function create(Request $request);

  abstract function list(Request $request);

  abstract function read(Request $request, $id);

  abstract function update(Request $request, $id);

  abstract function delete(Request $request, $id);
}
