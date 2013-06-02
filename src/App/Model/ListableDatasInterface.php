<?php

namespace App\Model;

interface ListableDatasInterface
{
	public function getListFields();

    public function getShowRole();

    public function getEditRole();

    public function getDeleteRole();

    public function getCreateRole();
}
