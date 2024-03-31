<?php

namespace App\Abstract\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class ResourceController extends Controller
{
  abstract function create(Request $request);

  abstract function list(Request $request);

  abstract function read(Request $request, $id);

  abstract function update(Request $request, $id);

  abstract function delete(Request $request, $id);
}
