<?php
	
			$this->load->model('email_this_page_model');
			checkReferrerUrl();
			$yourName=$this->input->post('yourName')?$this->input->post('yourName'):'';
			$friendName=$this->input->post('friendName')?$this->input->post('friendName'):'';
			$yourEmail=$this->input->post('yourEmail')?$this->input->post('yourEmail'):'';
			$friendEmail=$this->input->post('friendEmail')?$this->input->post('friendEmail'):'';
			$pageLink=$this->input->post('pageLink')?$this->input->post('pageLink'):'';
			$message=$this->input->post('message')?$this->input->post('message'):'';
			
			// Server Side Validation
			$this->form_validation->set_rules('yourName', 'yourName' ,'required');
			$this->form_validation->set_rules('friendName', 'friendName' ,'required');
			$this->form_validation->set_rules('friendEmail', 'friendEmail' ,'required|valid_email');
			$this->form_validation->set_rules('yourEmail', 'yourEmail' ,'required|valid_email');
			$this->form_validation->set_rules('pageLink', 'pageLink' ,'required');
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			
			if($this->form_validation->run())
			{	
				checkCaptcha(base_url().'contactus');
				$ip=$_SERVER['REMOTE_ADDR'];
				$MacID=$ip;
				$emalThisPageData=array(
									'recommendusID'=>0,
									'yourName'=>$yourName,
									'friendName'=>$friendName,
									'yourEmail'=>$yourEmail,
									'friendEmail'=>$friendEmail,
									'pageLink'=>$pageLink,
									'message'=>$message,
									'ip'=>$ip,
									'MacID'=>$MacID,
									'createdDate'=>date('Y-m-d H:i:s',strtotime('NOW')),
									);
				$recommendusID=$this->email_this_page_model->addEdit($emalThisPageData);
				if($recommendusID > 0){
						$formData=array('formID'=>$this->config->item('emailthispageFormID'));
						/*======================================*/
						//  Email Sent To Customer START
						/*======================================*/
							$replaceData = array('{var_friendName}'=>$friendName,
											'{var_sitename}'=>$this->config->item('site_title'),
											'{var_yourName}'=>$yourName,
											'{var_yourEmail}'=>$yourEmail,
											'{var_pageLink}'=>$pageLink,
											'{var_description}'=>nl2br($message)
											);
							sendCustomerEmail($formData,$friendEmail,$replaceData);				
						/*======================================*/
						//  Email Sent To Customer END
						/*======================================*/
						/*======================================*/
						//  Email Sent To Admin START
						/*======================================*/
							$replaceData = array('{var_friendName}'=>$friendName,
									'{var_friendEmail}'=>$friendEmail,
									'{var_yourName}'=>$yourName,
									'{var_yourEmail}'=>$yourEmail,
									'{var_sitename}'=>$this->config->item('site_title'),
									'{var_pageLink}'=>$pageLink,
									'{var_description}'=>nl2br($message)
									);
							sendAdminEmail($formData,$replaceData);
						/*======================================*/
						//  Email Sent To Admin END
						/*======================================*/
						$_POST['formID']=$this->config->item('emailthispageFormID');
						fun_redirect(base_url().'thankyou',$_POST);
					}else{
						$this->session->set_flashdata('errorMsg', 'Something wrong!');
						fun_redirect(base_url().'emailthispage',$_POST);
					}
			}else{
				$this->session->set_flashdata('errorMsg', validation_errors());
				fun_redirect(base_url().'emailthispage',$_POST);
			}
?>