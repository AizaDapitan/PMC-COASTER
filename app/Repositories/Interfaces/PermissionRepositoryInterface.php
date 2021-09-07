<?php

namespace App\Repositories\Interfaces;

interface PermissionRepositoryInterface
{
    public function all();

    public function create($fields);

    public function update($fields, $id);

    public function destroy($id);
    
    public function getById($id);
}