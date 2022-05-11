<?php
namespace App\Controllers;

use Myth\Auth\Authorization\PermissionModel;

class Permission extends BaseController
{
	public function index()
	{
		helper('form');
        $permission=new PermissionModel();
        $list=$permission->findAll();
        return parent::_render('permission/index',array('list'=>$list));
	}
	public function create()
	{       
        helper('form');
        if ($this->request->getMethod() == "post") {
            $permission=new PermissionModel();
            //print_r($_POST); exit;
            $flag=$permission->save([
                'name'	=>	$this->request->getPost('name'),
                'description'	=>	$this->request->getPost('description')
            ]);
            if($flag==false) {
                return parent::_render('permission/create', [
                        'errors' => $permission->errors()
                    ]); 
                }
            else {
                session()->setFlashdata("message", "Permission saved successfully");
                return redirect('permission');
            }
        } else 
            return parent::_render('permission/create',array());
	}
    public function edit($id) {
      helper('form');
      $permission = new PermissionModel();
      $permissions = $permission->find($id);
      $data['permissions'] = $permissions;
      return parent::_render('permission/edit',$data);

    }
    public function update() {
        $id=$this->request->getPost('id');
        if ($this->request->getMethod() == "post") {
            $permission=new PermissionModel();
            //print_r($_POST); exit;
            $flag=$permission->update($id,[
                'name'	=>	$this->request->getPost('name'),
                'description'	=>	$this->request->getPost('description')
            ]);
            if($flag==false) {
                //echo route('permission/edit/'.$id); exit;
                return redirect()->to('permission/edit/'.$id)->withInput()->with('errors',$permission->errors()); 
            }
            else {
                session()->setFlashdata("message", "Permission updated successfully");
                return redirect('permission');
            }
        } else 
            return parent::_render('permission',array());
    }
    public function delete() {
        $id=$this->request->getPost('permission_id');
        if(empty($id)) {
            session()->setFlashdata("error", "Id is not defined");
        } else {
            $permission=new PermissionModel();
            $permission->delete($id);
            session()->setFlashdata("message", "Permission deleted successfully");
        }
        return redirect('permission');
    }
}
