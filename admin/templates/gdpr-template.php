<?php
   /**
    * Template Name: GDPR Template (Rectify, Delete, Download and Complaint)
    *
    */
   get_header(); ?>
<style>
	select#gdpr-dropdown {
		border-top-right-radius: 0px;
		border-bottom-right-radius: 0px;
		float: left;
		width: 250px;
		height: 34px;
	}
	.input-group.mb-12.gdpr-form .btn {
	   border-top-left-radius: 0px;
	   border-bottom-left-radius: 0px;
	}
	button.rounded-right.btn.btn-gdpr {
	   background: #000;
	   color: #fff;
	}
	header.gdpr-header {
		background: transparent;
		margin-bottom: 31px;
	}
	.gdpr-container.container p {
		margin-bottom: 20px;
		line-height: normal;
	}
	.dpr-form {
		margin-bottom: 50px;
	}
	h1.gdpr-page-title {
		font-size: 2rem;
	}
	button.btn-gdpr {
		background: #000;
		color: #fff;
		border: 0px;
		height: 34px;
		border-radius: 0px;
	}
	.gdpr-form-actions textarea {
		width: 100%;
		margin: 20px auto;
		margin-bottom: 20px;
	}
</style>
<div id="primary" class="full-width site-content">
   <header class="gdpr-header">
      <div class="container">
         <div class="row">
            <div class="col-md-12">
               <h1 class="gdpr-page-title"><?php echo get_the_title(); ?></h1>
            </div>
         </div>
      </div>
   </header>
   <div class="gdpr-container container">
      <div class="row" role="main">
         <div class="col-md-12">
            <h2><strong>GDPR Compliance</strong></h2> 
            <p><strong>What is GDPR?</strong></p>
            <p>The GDPR was approved and adopted by the EU Parliament in April 2016. The regulation will take effect after a two-year transition period and, unlike a Directive it does not require any enabling legislation to be passed by government; meaning it will be in force May 2018.</p>
            <p><strong>In light of a uncertain 'Brexit' -  I represent a data controller in the UK and want to know if I should still continue with GDPR planning and preparation?</strong></p>
            <p>If you process data about individuals in the context of selling goods or services to citizens in other EU countries then you will need to comply with the GDPR, irrespective as to whether or not you the UK retains the GDPR post-Brexit. If your activities are limited to the UK, then the position (after the initial exit period) is much less clear. The UK Government has indicated it will implement an equivalent or alternative legal mechanisms. Our expectation is that any such legislation will largely follow the GDPR, given the support previously provided to the GDPR by the ICO and UK Government as an effective privacy standard, together with the fact that the GDPR provides a clear baseline against which UK business can seek continued access to the EU digital market. (Ref: http://www.lexology.com/library/detail.aspx?g=07a6d19f-19ae-4648-9f69-44ea289726a0)</p>
            <p><strong>Who does the GDPR affect?</strong></p>
            <p>The GDPR not only applies to organisations located within the EU but it will also apply to organisations located outside of the EU if they offer goods or services to, or monitor the behaviour of, EU data subjects. It applies to all companies processing and holding the personal data of data subjects residing in the European Union, regardless of the company’s location.</p>
            <p>What constitutes personal data?</p>
            <p>Any information related to a natural person or ‘Data Subject’, that can be used to directly or indirectly identify the person. It can be anything from a name, a photo, an email address, bank details, posts on social networking websites, medical information, or a computer IP address.</p>
            <p><strong>What is the difference between a data processor and a data controller?</strong></p>
            <p>A controller is the entity that determines the purposes, conditions and means of the processing of personal data, while the processor is an entity which processes personal data on behalf of the controller.</p>
            <p><strong>Do data processors need 'explicit' or 'unambiguous' data subject consent - and what is the difference?</strong></p>
            <p>The conditions for consent have been strengthened, as companies will no longer be able to utilise long illegible terms and conditions full of legalese, as the request for consent must be given in an intelligible and easily accessible form, with the purpose for data processing attached to that consent - meaning it must be unambiguous. Consent must be clear and distinguishable from other matters and provided in an intelligible and easily accessible form, using clear and plain language. It must be as easy to withdraw consent as it is to give it.​  Explicit consent is required only for processing sensitive personal data - in this context, nothing short of “opt in” will suffice. However, for non-sensitive data, “unambiguous” consent will suffice.</p>
            <p><strong>What about Data Subjects under the age of 16?</strong></p>
            <p>Parental consent will be required to process the personal data of children under the age of 16 for online services; member states may legislate for a lower age of consent but this will not be below the age of 13.</p>
            <p><strong>What is the difference between a regulation and a directive?</strong></p>
            <p>A regulation is a binding legislative act. It must be applied in its entirety across the EU, while a directive is a legislative act that sets out a goal that all EU countries must achieve. However, it is up to the individual countries to decide how. It is important to note that the GDPR is a regulation, in contrast the the previous legislation, which is a directive.</p>
            <p><strong>How does the GDPR affect policy surrounding data breaches?</strong></p>
            <p>Proposed regulations surrounding data breaches primarily relate to the notification policies of companies that have been breached. Data breaches which may pose a risk to individuals must be notified to the DPA within 72 hours and to affected individuals without undue delay.</p>
            <div class="dpr-form">
               <select class="custom-select" id="gdpr-dropdown">
                  <option selected disabled>--CHOOSE ACTION--</option>
                  <option value="1">Request to Correct Data</option>
                  <option value="2">Complaint Form</option>
                  <option value="3">Request to Delete Data</option>
                  <option value="4">Download Personal Data</option>
               </select>
               <div class="input-group-prepend">
                  <button class="btn-gdpr" type="button">SHOW FORM</button>
               </div>
            </div>
            <div class="gdpr-form-actions">
               <?php
			   
				$privacy_policy = !empty(get_option('pvgdpr_privacy_policy')) ?  get_option('pvgdpr_privacy_policy') : '/privacy-policy';
				$cookie_policy = !empty(get_option('pvgdpr_cookie_policy')) ?  get_option('pvgdpr_cookie_policy') : '/cookie-policy';
				$terms_conditions = !empty(get_option('pvgdpr_terms_conditions')) ?  get_option('pvgdpr_terms_conditions') : '/terms-and-conditions';
				
                  echo '
					<div class="invisible gdpr-tab rectify">
						<h3>Data Rectification Request</h3>
						<form action="'.esc_url( admin_url('admin-post.php') ).'" method="post" >							
						<input type="hidden" name="action" value="gdpr_form">
							<input type="hidden" name="type" value="rectify" />
							<input class="pv-gdpr" type="email" name="email" placeholder="Email Address" required />
							<textarea class="pv-gdpr" name="message" placeholder="Your message here..."></textarea>
							<div>
								<p style="margin-top:20px;"><input type="checkbox" id="consent-rectify"/> I consent this site to collect my Information.
								This form collects your information so that we can correspond with you. Please check our <a href="'.$privacy_policy.'">Privacy Policy</a>  and <a href="'.$terms_conditions.'">Terms and Conditions</a>.</p>
							</div>
							<button data-target="#consent-rectify" type="submit" class="security-form-button">Submit</button>
						</form>						
					</div>
				  ';
                  
                  echo '
					<div class="invisible gdpr-tab complaint">
						<h3>Complaint Form </h3>
						<form action="'.esc_url( admin_url('admin-post.php') ).'" method="post" >						
						<input type="hidden" name="action" value="gdpr_form">
							<input class="pv-gdpr" type="hidden" name="type" value="complaint" />
							<input class="pv-gdpr" type="email" name="email" placeholder="Email Address" required />
							<textarea class="pv-gdpr" name="message" placeholder="Your complaint here..."></textarea>
							<div>
								<p style="margin-top:20px;"><input type="checkbox" id="consent-complaint"/> I consent this site to collect my Information.
								This form collects your information so that we can correspond with you. Please check our <a href="'.$privacy_policy.'">Privacy Policy</a>  and <a href="'.$terms_conditions.'">Terms and Conditions</a>.</p>
							</div>
							<button data-target="#consent-complaint" type="submit" class="security-form-button">File a complaint</button>
						</form>						 
					</div>
				  ';
                  
                  echo '
					<div class="invisible gdpr-tab delete">
						<h3>Data Deletion Request</h3>
						<form action="'.esc_url( admin_url('admin-post.php') ).'" method="post" >						
						<input type="hidden" name="action" value="gdpr_form">
							<input class="pv-gdpr" type="hidden" name="type" value="delete" />
							<input class="pv-gdpr" type="email" name="email" placeholder="Email Address" required />
							<div>
								<p style="margin-top:20px;"><input type="checkbox" id="consent-delete"/> I consent this site to collect my Information.
								This form collects your information so that we can correspond with you. Please check our <a href="'.$privacy_policy.'">Privacy Policy</a>  and <a href="'.$terms_conditions.'">Terms and Conditions</a>.</p>
							</div>
							<button data-target="#consent-delete" type="submit" class="security-form-button">Request to delete your data</button>
						</form>							
					</div>
					'; 
                  
                  echo '
					  <div class="invisible gdpr-tab download-data">
						<h3>Download Data Request</h3>
						<form action="'.esc_url( admin_url('admin-post.php') ).'" method="post" >							
						<input type="hidden" name="action" value="gdpr_form">
							<input class="pv-gdpr" type="hidden" name="type" value="download" />
							<input class="pv-gdpr" type="email" name="email" placeholder="Email Address" required />
							<div>
								<p style="margin-top:20px;"><input type="checkbox" id="consent-download"/> I consent this site to collect my Information.
								This form collects your information so that we can correspond with you. Please check our <a href="'.$privacy_policy.'">Privacy Policy</a>  and <a href="'.$terms_conditions.'">Terms and Conditions</a>.</p>
							</div>
							<button data-target="#consent-download" type="submit" class="security-form-button">Request to download your data</button>
						</form>							
					  </div>
				  ';
                  ?>
            </div>
            <script type="text/javascript" >
				$(function(){
					console.log("GDPR Loaded.............100%");
					var select = $("#gdpr-dropdown");
					var button = $(".btn-gdpr");
					button.click(function(b){
						if(select.val()){
							$(".gdpr-form-actions").attr({"style":"padding:2rem; background:#f9f9f9;"});
						}
						$('.gdpr-tab').addClass('invisible');
						if(select.val() == 1){
							$('.gdpr-tab.rectify').removeClass('invisible');
						}else if (select.val() == 2){
							$('.gdpr-tab.complaint').removeClass('invisible');
						}else if(select.val() == 3){
							$('.gdpr-tab.delete').removeClass('invisible');
						}else if(select.val() == 4){
							$('.gdpr-tab.download-data').removeClass('invisible');
						}
					});
					var consent = $(".security-form-button");
						consent.click(function(e){
							var tar = $(this).data('target');
							if(!$(tar).prop("checked")){
								console.log(false);
								e.preventDefault();
								alert("You must give consent to this site to collect your information.");
							}else{
								console.log(true);
							}
					});
				});
            </script>
         </div>
         <!-- .col-md-12 -->
      </div>
      <!--.row -->
   </div>
   <!-- .container-fluid -->
</div>
<!-- .primary -->
<?php get_footer(); ?>