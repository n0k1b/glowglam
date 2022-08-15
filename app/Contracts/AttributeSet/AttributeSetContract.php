<?php

namespace App\Contracts\AttributeSet;

interface AttributeSetContract
{
    public function getAllAttributeSet();

    public function storeAttributeSet($data);

    public function getById($id);

    public function updateAttributeSetById($id, $data);

    public function active($id);

    public function inactive($id);

    public function bulkAction($type, $ids);

    public function destroy($id);
}
