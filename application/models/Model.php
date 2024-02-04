<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crm_model extends CI_Model {

    protected $table = 'services';

        public function __construct()
        {
            parent::__construct();
            date_default_timezone_set("Asia/Kolkata");
        }

        public function check()
        {
            $result = $this->db->select('*')
            ->from('users')
            ->where('username', $this->input->post('name'))
            ->limit(1)
            ->get();


            if($result->num_rows() < 1){
                return false;
            }
            elseif(password_verify($this->input->post('password'), $result->result()[0]->password)){
                $user = [ 'id' => $result->result()[0]->id,
                          'fullname' => $result->result()[0]->fullname,
                          'username' => $result->result()[0]->username,
                          'privilage' => $result->result()[0]->privilage,
                          'address' => $result->result()[0]->address,
                          'contact' => $result->result()[0]->contact
                ];
                $this->session->set_userdata('user', $user);
                return true;
            }
            else{
                return false;
            }
        }
        public function getuser($id)
        {
            return $this->db->select('*')
            ->from('users')
            ->where('id',$id)
            ->get()->row();
        }

        public function analytics($privilage)
        {
            return $this->db->query('SELECT * FROM users WHERE privilage = '.$privilage);
        }

        public function pendingc($id)
        {
            return $this->db->query("SELECT * FROM assign WHERE staff_id = ".$id." AND status = 'assigned'");
        }

        public function requests()
        {
            return $this->db->query("SELECT * FROM requests WHERE status = 'Approved'");
        }

        public function approvalc()
        {
            return $this->db->query("SELECT * FROM requests WHERE status = 'Submitted'");
        }

        public function servicereqc()
        {
            return $this->db->query("SELECT * FROM servicereq WHERE status= 'requested'");
        }

        public function packagereqc()
        {
            return $this->db->query("SELECT * FROM packagereq WHERE status= 'requested'");
        }

        public function cc($id)
        {
            return $this->db->query('SELECT * FROM users WHERE cby = '.$id);
        }

        public function sc($id)
        {
            return $this->db->query("SELECT * FROM users WHERE privilage = '357'");
        }

        public function cw()
        {
            return $this->db->query("SELECT * FROM requests WHERE status = 'Verifyed'");
        }

        public function pw()
        {
            return $this->db->query("SELECT * FROM assign WHERE status = 'assigned'");
        }

        public function ap()
        {
            return $this->db->query("SELECT * FROM packages");
        }

        public function as()
        {
            return $this->db->query("SELECT * FROM services");
        }

        public function signin($array)
        {
            if ($this->db->insert('users',$array))
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }

        public function listusers($ur)
        {
            $this->db->order_by("id","desc");
            return $this->db->select('*')
            ->from('users')
            ->where('privilage',$ur)
            ->get()->result();
        }

        public function clistusers($ur,$id)
        {
            $this->db->order_by("id","desc");
            return $this->db->select('*')
            ->from('users')
            ->where('privilage',$ur)
            ->where('cby',$id)
            ->get()->result();
        }

        public function getrow($id)
        {
            $result = $this->db->select('*')
            ->from('users')
            ->where('id',$id)
            ->get()->row();
            return $result;
        }

        public function removeusers($id)
        {
            $this->load->database();
            $this->load->model('Crm_model');
            $result = $this->Crm_model->getrow($id);

            $this->db->insert('usersbin',$result);

            $this->db->where('id',$id);
            $this->db->delete('users');
            return TRUE;
        }

        public function updateuser($id,$formdata)
        {
            $this->db->where('id',$id);
            $this->db->update('users',$formdata);
            return TRUE;
        }

        public function saveservice($data)
        {
            if($this->db->insert('services',$data))
            {
                $status = "exist";
                return $status;
            }
            else
            {
                $status = "success";
                return $status;
            }
        }

        public function listservices()
        {
            return $this->db->select('*')
            ->from('services')
            ->get()->result();
        }

    public function get_count() {
        return $this->db->count_all($this->table);
    }

    public function get_services($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->get($this->table);

        return $query->result();
    }

        public function modservice($id,$formdata)
        {
            $this->db->where('id',$id);
            $this->db->update('services',$formdata);
            return TRUE;
        }

        public function modpackage($id,$formdata)
        {
            $this->db->where('id',$id);
            $this->db->update('packages',$formdata);
            return TRUE;
        }

        public function dropservice($id)
        {
            $this->db->where('id',$id);
            $this->db->delete('services');
            return TRUE;
        }

        public function droppackage($id)
        {
            $this->db->where('id',$id);
            $this->db->delete('packages');
            return TRUE;
        }

        public function servicerow($id)
        {
            return  $this->db->select('*')
            ->where('id',$id)
            ->from('services')
            ->get()->row();
        }

        public function savepackage($data)
        {
            return $this->db->insert('packages',$data);
        }

        public function verifications()
        {
            return $this->db->select('*')
            ->from('requests')
            ->where('status',"Approved")
            ->get()->result();
        }

        public function saveservicedata($data)
        {
            if($this->db->insert('requests',$data))
            {
                $insert_id = $this->db->insert_id();
                return $insert_id;
            }
            else
            {
                $status = "can't get id";
                return $status;
            }
        }

        public function compleated($id)
        {
            $this->db->where('id',$id);
            $this->db->set('status', "Compleated");
            $this->db->update('assign');
            return TRUE;
        }

        public function addimg($f,$r)
        {
            $this->db->set('name', $f);
            $this->db->set('req_id', $r);
            $this->db->insert('gallery');
        }

        public function approvals()
        {
            return $this->db->select('*')
            ->from('requests')
            ->where('status',"Submitted")
            ->get()->result();
        }
        
        public function approve($id,$aby)
        {
            $this->db->where('id',$id);
            $this->db->set('status', "Approved");
            $this->db->set('aby', $aby);
            $this->db->update('requests');
            return TRUE;
        }

        public function delete($id,$aby,$reason)
        {
            $this->db->where('id',$id);
            $this->db->set('status', "Deleted");
            $this->db->set('aby', $aby);
            $this->db->set('reason', $reason);
            $this->db->update('requests');
            return TRUE;
        }

        public function verify($id,$vby)
        {
            $this->db->where('id',$id);
            $this->db->set('status', "Verifyed");
            $this->db->set('vby', $vby);
            $this->db->update('requests');
            return TRUE;
        }

        public function reject($id,$vby,$reason)
        {
            $this->db->where('id',$id);
            $this->db->set('status', "Rejected");
            $this->db->set('vby', $vby);
            $this->db->set('rreason', $reason);
            $this->db->update('requests');
            return TRUE;
        }

        public function status($id)
        {
            return $this->db->select('*')
            ->from('requests')
            ->where('staff_id',$id)
            ->get()->result();
        }

        public function servicereport($id)
        {
            return $this->db->select('*')
            ->from('requests')
            ->where('staff_id',$id)
            ->get()->result();
        }

        public function getname($id)
        {
            return $this->db->select('*')
            ->from('users')
            ->where('id',$id)
            ->get()->row();
        }

        public function images($id)
        {
            return $this->db->select('*')
            ->from('gallery')
            ->where('req_id',$id)
            ->get()->result();
        }

        public function packages()
        {
            return $this->db->select('*')
            ->from('packages')
            ->get()->result();
        }

        public function savereqservice($array)
        {
            $this->db->insert('servicereq',$array);
        }

        public function savereqpackage($array)
        {
            $this->db->insert('packagereq',$array);
        }

        public function history($id)
        {
            return $this->db->select('*')
            ->from('requests')
            ->where('customer_id',$id)
            ->get()->result();
        }

        public function sh($id)
        {
            return $this->db->query('SELECT * FROM requests WHERE customer_id = '.$id);
        }

        public function ps($id)
        {
            return $this->db->query("SELECT * FROM servicereq WHERE custid = '".$id."' AND status = 'requested'");
        }

        public function pp($id)
        {
            return $this->db->query("SELECT * FROM packagereq WHERE custid = '".$id."' AND status = 'requested'");
        }

        public function pid($pkg)
        {
            return $this->db->select('name')
            ->from('packages')
            ->where('id',$pkg)
            ->get()->row();
        }

        public function servicerequests()
        {
            return $this->db->select('*')
            ->from('servicereq')
            ->where('status','requested')
            ->get()->result();
        }

        public function packagerequests()
        {
            return $this->db->select('*')
            ->from('packagereq')
            ->where('status','requested')
            ->get()->result();
        }

        public function edita($id,$a,$b,$c,$d,$e,$f,$h)
        {
            $this->db->where('id',$id);
            $this->db->set('fullname',$a);
            $this->db->set('gender',$b);
            $this->db->set('age',$c);
            $this->db->set('address',$d);
            $this->db->set('contact',$e);
            $this->db->set('email',$f);
            $this->db->set('password',$h);
            $this->db->update('users');
            return TRUE;
        }

        public function editpass($id,$h)
        {
            $this->db->where('id',$id);
            $this->db->set('password',$h);
            $this->db->update('users');
            return TRUE;
        }

        public function assign($array,$table,$id)
        {
            $this->db->where('id',$id);
            $this->db->set('status',"assigned");
            $this->db->update($table);
            if ($this->db->insert('assign',$array))
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }

        public function getwork($id)
        {
            return $this->db->select('*')
            ->from('assign')
            ->where('staff_id',$id)
            ->where('status','assigned')
            ->get()->result();
        }

        public function getid($table,$id)
        {
            return $this->db->select('*')
            ->from($table)
            ->where('id',$id)
            ->get()->row();
        }

        public function getsn($id)
        {
            return $this->db->select('*')
            ->from("services")
            ->where('id',$id)
            ->get()->row();
        }

        public function getpn($id)
        {
            return $this->db->select('*')
            ->from("packages")
            ->where('id',$id)
            ->get()->row();
        }

        public function getassrow($id)
        {
            return $this->db->select('*')
            ->from("assign")
            ->where('id',$id)
            ->get()->row();
        }

        public function bill($id)
        {
            return $this->db->select('*')
            ->from('requests')
            ->where('customer_id',$id)
            ->get()->result();
        }

        public function reports()
        {
            return $this->db->select('*')
            ->from('requests')
            ->get()->result();
        }
        public function all_count($table)
        {
            return $this->db->count_all($table);
        }

        public function all_countw($table,$col,$val)
        {
            return $this->db->query("SELECT * FROM ".$table." WHERE ".$col." = '".$val."'");
        }

        public function get_requests($limit, $start)
        {
            $this->db->limit($limit, $start);
            $query = $this->db->get('requests');

            return $query->result();
        }

        public function invoices()
        {
            return $this->db->select('distinct(requests.customer_id)')
            ->from('requests')
            ->join('users', 'users.id = requests.customer_id')
            ->get()->result();
        }

        public function insert($table,$data)
        {
            return $this->db->insert($table,$data);
        }

        public function table($table)
        {
            return $this->db->select('*')
            ->from($table)
            ->get()->result();
        }

        public function tablewhere($table,$col,$id)
        {
            return $this->db->select('*')
            ->from($table)
            ->where($col,$id)
            ->get()->result();
        }

        public function removeinvoice($id)
        {
            $this->db->where('id',$id);
            $this->db->delete('invoices_details');
            return TRUE;
        }

        public function getinvo($count)
        {
            return $this->db->select('*')
            ->from('invoices_details')
            ->where('invo_id',$count)
            ->get()->result();
        }

        public function invocount()
        {
            return $this->db->select('count')
            ->from('invo_count')
            ->limit(1)
            ->get()->result();
        }

        public function invoicetotal($id)
        {
            return $this->db->select('price')
            ->from('invoices_details')
            ->where('invo_id',$id)
            ->get()->result();
        }

        public function inc($count,$inc)
        {
            $this->db->where('count',$count);
            $this->db->set('count',$inc);
            $this->db->update('invo_count');
            return TRUE;
        }

        public function invocus()
        {
            return $this->db->select('distinct(cus_id)')
            ->from('invoices')
            ->get()->result();
        }

        public function invoget($id)
        {
            return $this->db->select('*')
            ->from('invoices')
            ->where('cus_id',$id)
            ->get()->row();
        }

}
?>