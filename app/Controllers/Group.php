<?php
namespace App\Controllers;

use Myth\Auth\Authorization\PermissionModel;
use Myth\Auth\Authorization\GroupModel;

class Group extends BaseController
{
	public function index()
	{
		helper('form');
        $group=new GroupModel();
        $list=$group->getData();
        return parent::_render('admin/group/index',array('list'=>$list));
	}
	public function create()
	{       
        helper(['form', 'url']);
        $permission=new PermissionModel();
        $l1=$permission->getValues();
        $list=array();
        foreach($l1 as $v)
            $list[$v['id']]=$v['name'];
        if ($this->request->getMethod() == "post") {
           $group=new GroupModel();
            //print_r($_POST); exit;
            $flag=$group->save([
                'name'	=>	$this->request->getPost('name'),
                'description'	=>	$this->request->getPost('description')
            ]);
            if($flag==false) {
                return parent::_render('admin/group/create', [
                        'errors' => $group->errors(),
                        'permission'=>$list
                    ]); 
                }
            else {
                $validation =  \Config\Services::validation();
                $input = $this->validate([
                    'permissions' => 'required',
                ]);    
                if (!$input) {
                    return redirect()->back()->withInput()->with('errors',$validation->getErrors()); 
                }  
                $group_id=$group->insertId();
                $per=$this->request->getPost('permissions');
                foreach($per as $p) 
                    $group->addPermissionToGroup($p,$group_id);
                session()->setFlashdata("message", "Group saved successfully");
                return redirect('groups');
            }
        } else 
            return parent::_render('admin/group/create',array('permission'=>$list));
	}
    public function edit($id) {
      helper('form');
      $permission=new PermissionModel();
      $l1=$permission->getValues();
      $list=array();
      foreach($l1 as $v)
        $list[$v['id']]=$v['name'];
      $group = new GroupModel();
      $groups = $group->find($id);
      $group_ids=$group->getPermissionsForGroup($id);      
      $data['groups'] = $groups;
      $data['permission']=$list;
      $data['group_ids']=array_keys($group_ids);
      return parent::_render('admin/group/edit',$data);

    }
    public function update() {
        $id=$this->request->getPost('id');
        if ($this->request->getMethod() == "post") {
            $group=new GroupModel();
            //print_r($_POST); exit;
            $flag=$group->update($id,[
                'name'	=>	$this->request->getPost('name'),
                'description'	=>	$this->request->getPost('description')
            ]);
            if($flag==false) {
                //echo route('admin/group/edit/'.$id); exit;
                return redirect()->to('admin/group/edit/'.$id)->withInput()->with('errors',$group->errors()); 
            }
            else {
                $validation =  \Config\Services::validation();
                $input = $this->validate([
                    'permissions' => 'required',
                ]);
                if (!$input) {
                    return redirect()->back()->withInput()->with('errors',$validation->getErrors()); 
                }
                $group->removeGroupFromAllPermission($id);
                $per=$this->request->getPost('permissions');
                foreach($per as $p) 
                    $group->addPermissionToGroup($p,$id);
                session()->setFlashdata("message", "Group updated successfully");
                return redirect('groups');
            }
        } else 
            return parent::_render('groups',array());
    }
    public function delete() {
        $id=$this->request->getPost('group_id');
        if(empty($id)) {
            session()->setFlashdata("error", "Id is not defined");
        } else {
            $group=new GroupModel();
            $group->removeGroupFromAllPermission($id);
            $group->delete($id);
            session()->setFlashdata("message", "Group deleted successfully");
        }
        return redirect('groups');
    }
}
