<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File extends CI_Controller {

  public function pbl($id)
  {
    $this->load->model('Pbl_model');

    $file = $this->Pbl_model->get_file_by_id($id);
    if (!$file || !$file->file_path) {
      show_404();
    }

    $fullPath = FCPATH . $file->file_path;

    if (!file_exists($fullPath)) {
      show_404();
    }

    $mime = mime_content_type($fullPath);
    header('Content-Type: '.$mime);
    header('Content-Disposition: inline; filename="'.basename($fullPath).'"');
    header('Content-Length: '.filesize($fullPath));

    readfile($fullPath);
    exit;
  }
}


/* End of file File.php */
/* Location: ./application/controllers/File.php */