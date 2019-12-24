<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Zone_Cookie
 * @subpackage Zone_Cookie/admin/model
 * @author     Zekinah Lecaros <zjlecaros@gmail.com> 
 * 
 */

/******************************************************************
This Model is the parent model class that returns database object
 *******************************************************************/

require_once(ABSPATH . 'wp-config.php');


class Zone_Cookie_Model_Config
{

    public $wpdb;

    public function db_connect()
    {
        $localhost    = DB_HOST;
        $user        = DB_USER;
        $pw            = DB_PASSWORD;
        $database    = DB_NAME;
        $db = new mysqli($localhost, $user, $pw, $database);
        if ($db) {
            return $db;
        } else {
            die("Connection failed: " . $db->connect_error);
        }
    }

    public function createTable()
    {
        global $wpdb;
        $db = $this->db_connect();
        /** Requester */
        $query = "
			CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "zn_cookie_requester` (
			 `RequesterID` int(11) NOT NULL AUTO_INCREMENT,
			 `FirstName` varchar(50) NOT NULL,
			 `LastName` varchar(50) NOT NULL,
			 `Phone` varchar(50) NOT NULL,
			 `Email` varchar(50) NOT NULL,
			 `City` varchar(100) NOT NULL,
			 `State` varchar(100) NOT NULL,
			 PRIMARY KEY (`RequesterID`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
			";
        /** Type of Request */
        $query1 = "
			CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "zn_cookie_type_request` (
			`TypeofRequest_ID` int(11) NOT NULL AUTO_INCREMENT,
			`Type_of_Request` varchar(50) NOT NULL,
			`Status` int(1) NOT NULL DEFAULT '1',
			`Trash` int(1) NOT NULL DEFAULT '0',
		   PRIMARY KEY (`TypeofRequest_ID`)
		   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
            ";
        /** Request List*/
        $query2 = "
			CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "zn_cookie_request` (
			`Request_ID` int(11) NOT NULL AUTO_INCREMENT,
			`Requester_ID` int(11) NOT NULL,
            `TypeofRequest_ID` int(11) NOT NULL,
            `Additional_Message` TEXT NOT NULL,
            `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `Request` int(5) NOT NULL DEFAULT '1',
			`Status` int(1) NOT NULL DEFAULT '0',
			`Trash` int(1) NOT NULL DEFAULT '0',
		   PRIMARY KEY (`Request_ID`)
		   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
            ";

        /** GDPR Content*/
        $query3 = "
			CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "zn_cookie_content` (
            `Gdpr_Content_ID` int(11) NOT NULL AUTO_INCREMENT,
            `Gdpr_Page_Content` TEXT NOT NULL,
            `Ccpa_Page_Content` TEXT NOT NULL,
			`Privacy_Policy_Link` TEXT,
            `Cookie_Policy_Link` TEXT,
            `Terms_and_Condition_Link` TEXT,
			`Message` TEXT NOT NULL,
			`Allow_Button` TEXT NOT NULL,
			`Deny_Button` TEXT NOT NULL,
		   PRIMARY KEY (`Gdpr_Content_ID`)
		   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
            ";

        /** GDPR Layout*/
        $query4 = "
			CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "zn_cookie_layout` (
			`Gdpr_Layout_ID` int(11) NOT NULL AUTO_INCREMENT,
			`Position` TEXT NOT NULL,
            `Layout` TEXT NOT NULL,
            `Color_Banner` TEXT NOT NULL,
			`Color_Banner_Text` TEXT NOT NULL,
			`Color_Button` TEXT NOT NULL,
			`Color_Button_Text` TEXT NOT NULL,
			`Compliance` TEXT NOT NULL,
		   PRIMARY KEY (`Gdpr_Layout_ID`)
		   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
            ";

        /** GDPR Settings*/
        $query5 = "
			CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "zn_cookie_settings` (
			`GDPR_Settings_ID` int(11) NOT NULL AUTO_INCREMENT,
			`Email_Approved_Template` TEXT NOT NULL,
            `Email_Dispproved_Template` TEXT NOT NULL,
            `Email_Receiver` TEXT,
			`Email_Status` int(5) NOT NULL DEFAULT '1',
		   PRIMARY KEY (`GDPR_Settings_ID`)
		   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
            ";
            
        /** Inseert Request Type*/
        $queryI1 = "
			INSERT INTO `" . $wpdb->prefix . "zn_cookie_type_request` (`Type_of_Request`) VALUES
			('Request to Correct Data'),
			('Complaint Form'),
			('Request to Delete Data'),
			('Request to Download Personal Data')
            ";

        $gdpr_content = "<h2><strong>GDPR Compliance</strong></h2> 
            <p><strong>What is GDPR?</strong></p>
            <p>The GDPR was approved and adopted by the EU Parliament in April 2016. The regulation will take effect after a two-year transition period and, unlike a Directive it does not require any enabling legislation to be passed by government; meaning it will be in force May 2018.</p>
            <p><strong>In light of a uncertain `Brexit` -  I represent a data controller in the UK and want to know if I should still continue with GDPR planning and preparation?</strong></p>
            <p>If you process data about individuals in the context of selling goods or services to citizens in other EU countries then you will need to comply with the GDPR, irrespective as to whether or not you the UK retains the GDPR post-Brexit. If your activities are limited to the UK, then the position (after the initial exit period) is much less clear. The UK Government has indicated it will implement an equivalent or alternative legal mechanisms. Our expectation is that any such legislation will largely follow the GDPR, given the support previously provided to the GDPR by the ICO and UK Government as an effective privacy standard, together with the fact that the GDPR provides a clear baseline against which UK business can seek continued access to the EU digital market. (Ref: http://www.lexology.com/library/detail.aspx?g=07a6d19f-19ae-4648-9f69-44ea289726a0)</p>
            <p><strong>Who does the GDPR affect?</strong></p>
            <p>The GDPR not only applies to organisations located within the EU but it will also apply to organisations located outside of the EU if they offer goods or services to, or monitor the behaviour of, EU data subjects. It applies to all companies processing and holding the personal data of data subjects residing in the European Union, regardless of the company’s location.</p>
            <p>What constitutes personal data?</p>
            <p>Any information related to a natural person or ‘Data Subject’, that can be used to directly or indirectly identify the person. It can be anything from a name, a photo, an email address, bank details, posts on social networking websites, medical information, or a computer IP address.</p>
            <p><strong>What is the difference between a data processor and a data controller?</strong></p>
            <p>A controller is the entity that determines the purposes, conditions and means of the processing of personal data, while the processor is an entity which processes personal data on behalf of the controller.</p>
            <p><strong>Do data processors need `explicit` or `unambiguous` data subject consent - and what is the difference?</strong></p>
            <p>The conditions for consent have been strengthened, as companies will no longer be able to utilise long illegible terms and conditions full of legalese, as the request for consent must be given in an intelligible and easily accessible form, with the purpose for data processing attached to that consent - meaning it must be unambiguous. Consent must be clear and distinguishable from other matters and provided in an intelligible and easily accessible form, using clear and plain language. It must be as easy to withdraw consent as it is to give it.​  Explicit consent is required only for processing sensitive personal data - in this context, nothing short of “opt in” will suffice. However, for non-sensitive data, “unambiguous” consent will suffice.</p>
            <p><strong>What about Data Subjects under the age of 16?</strong></p>
            <p>Parental consent will be required to process the personal data of children under the age of 16 for online services; member states may legislate for a lower age of consent but this will not be below the age of 13.</p>
            <p><strong>What is the difference between a regulation and a directive?</strong></p>
            <p>A regulation is a binding legislative act. It must be applied in its entirety across the EU, while a directive is a legislative act that sets out a goal that all EU countries must achieve. However, it is up to the individual countries to decide how. It is important to note that the GDPR is a regulation, in contrast the the previous legislation, which is a directive.</p>
            <p><strong>How does the GDPR affect policy surrounding data breaches?</strong></p>
            <p>Proposed regulations surrounding data breaches primarily relate to the notification policies of companies that have been breached. Data breaches which may pose a risk to individuals must be notified to the DPA within 72 hours and to affected individuals without undue delay.</p>
            ";

        $ccpa_contents = "<a href='/privacy-policy/'>Privacy Policy</a>";
        $ccpa_content = "<h2><strong>CCPA Compliance</strong></h2> 
            <p><strong>Effective Date: January 1, 2020</strong></p>
            <p>This Privacy Notice for California Residents supplements the information contained in WEBSITE’s Privacy Policy and applies solely to all visitors, users, and others who reside in the State of California (“consumers” or “you”). We adopt this notice to comply with the California Consumer Privacy Act of 2018 (CCPA) and any terms defined in the CCPA have the same meaning when used in this notice.</p>
            <p><strong>INFORMATION WE COLLECT</strong></p>
            <p>The www.primeview.com website collects information that identifies, relates to, describes, references, is capable of being associated with, or could reasonably be linked, directly or indirectly, with a particular consumer or device (“personal information”). In particular, the Site has collected the following categories of personal information from its consumers within the last 12 months:</p>
            <table>
            <thead>
            <tr>
            <th>Category</th>
            <th>Examples</th>
            <th>Collected</th>
            <tr>
            </thead>
            <tbody>
            <tr>
            <td>A. Identifiers.</td>
            <td>A real name, alias, postal address, unique personal identifier, online identifier, Internet Protocol address, email address, account name, Social Security number, driver’s license number, passport number, or other similar identifiers.</td>
            <td>YES</td>
            </tr>
            <tr>
            <td>B. Personal information categories listed in the California Customer Records statute (Cal. Civ. Code § 1798.80(e)).</td>
            <td>A name, signature, Social Security number, physical characteristics or description, address, telephone number, passport number, driver’s license or state identification card number, insurance policy number, education, employment, employment history, bank account number, credit card number, debit card number, or any other financial information, medical information, or health insurance information.Some personal information included in this category may overlap with other categories.</td>
            <td>YES</td>
            </tr>
            <tr>
            <td>C. Protected classification characteristics under California or federal law.</td>
            <td>Age (40 years or older), race, color, ancestry, national origin, citizenship, religion or creed, marital status, medical condition, physical or mental disability, sex (including gender, gender identity, gender expression, pregnancy or childbirth and related medical conditions), sexual orientation, veteran or military status, genetic information (including familial genetic information).</td>
            <td>YES</td>
            </tr>
            <tr>
            <td>D. Commercial information.</td>
            <td>Records of personal property, products or services purchased, obtained, or considered, or other purchasing or consuming histories or tendencies.</td>
            <td>YES</td>
            </tr>
            <tr>
            <td>E. Biometric information.</td>
            <td>Genetic, physiological, behavioral, and biological characteristics, or activity patterns used to extract a template or other identifier or identifying information, such as, fingerprints, faceprints, and voiceprints, iris or retina scans, keystroke, gait, or other physical patterns, and sleep, health, or exercise data.</td>
            <td>NO</td>
            </tr>
            <tr>
            <td>F. Internet or other similar network activity.</td>
            <td>Browsing history, search history, information on a consumer’s interaction with a website, application, or advertisement.</td>
            <td>YES</td>
            </tr>
            <tr>
            <td>F. Internet or other similar network activity.</td>
            <td>Browsing history, search history, information on a consumer’s interaction with a website, application, or advertisement.</td>
            <td>YES</td>
            </tr>
            <tr>
            <td>G. Geolocation data.</td>
            <td>Physical location or movements.</td>
            <td>YES</td>
            </tr>
            <tr>
            <td>H. Sensory data.</td>
            <td>Audio, electronic, visual, thermal, olfactory, or similar information.</td>
            <td>NO</td>
            </tr>
            <tr>
            <td>I. Professional or employment-related information.</td>
            <td>Current or past job history or performance evaluations.</td>
            <td>NO</td>
            </tr>
            <tr>
            <td>J. Non-public education information (per the Family Educational Rights and Privacy Act (20 U.S.C. Section 1232g, 34 C.F.R. Part 99)).</td>
            <td>Education records directly related to a student maintained by an educational institution or party acting on its behalf, such as grades, transcripts, class lists, student schedules, student identification codes, student financial information, or student disciplinary records.</td>
            <td>NO</td>
            </tr>
            <tr>
            <td>K. Inferences drawn from other personal information.</td>
            <td>Profile reflecting a person’s preferences, characteristics, psychological trends, predispositions, behavior, attitudes, intelligence, abilities, and aptitudes.</td>
            <td>NO</td>
            </tr>
            </tbody>
            </table>
            <p>Personal information does not include:</p>
            <ul>
            <li>Publicly available information from government records.</li>
            <li>Deidentified or aggregated consumer information.</li>
            <li>Information excluded from the CCPA’s scope, like:</li>
            <ul>
            <li>health or medical information covered by the Health Insurance Portability and Accountability Act of 1996 (HIPAA) and the California Confidentiality of Medical Information Act (CMIA) or clinical trial data;</li>
            <li>personal information covered by certain sector-specific privacy laws, including the Fair Credit Reporting Act (FRCA), the Gramm-Leach-Bliley Act (GLBA) or California Financial Information Privacy Act (FIPA), and the Driver’s Privacy Protection Act of 1994.</li>
            </ul>
            </ul>
            <p>PrimeView obtains the categories of personal information listed above from the following categories of sources:</p>
            <ul>
            <li>Directly from you. For example, from forms you complete or products and services you purchase.</li>
            <li>Indirectly from you. For example, from observing your actions on our Site.</li>
            </ul>
            <p><strong>USE OF PERSONAL INFORMATION</strong></p>
            <p>We may use or disclose the personal information we collect for one or more of the following business purposes:</p>
            <ul>
            <li>To fulfill or meet the reason you provided the information. For example, if you share your name and contact information to ask a question about our products or services, we will use that personal information to respond to your inquiry. If you provide your personal information to purchase a product or service, we will use that information to process your payment and facilitate delivery. We may also save your information to facilitate new product orders or process returns. If you submit a story about your experience with PrimeView, we may post that story on our site without identifying you by name or address.</li>
            <li>To provide, support, personalize, and develop our Site, products, and services.</li>
            <li>To create, maintain, customize, and secure your account with us.</li>
            <li>To process your requests, purchases, transactions, and payments and prevent transactional fraud.</li>
            <li>To provide you with support and to respond to your inquiries, including to investigate and address your concerns and monitor and improve our responses.</li>
            <li>To personalize your Site experience.</li>
            <li>For testing, research, analysis, and product development, including to develop and improve our Site, products, and services.</li>
            <li>To respond to law enforcement requests and as required by applicable law, court order, or governmental regulations.</li>
            <li>As described to you when collecting your personal information or as otherwise set forth in the CCPA.</li>
            </ul>
            <p>PrimeView will not collect additional categories of personal information or use the personal information we collected for materially different, unrelated, or incompatible purposes without providing you notice.</p>
            <p><strong>SHARING PERSONAL INFORMATION</strong></p>
            <p>PrimeView may disclose your personal information to a third party for a business purpose. When we disclose personal information for a business purpose, we enter a contract that describes the purpose and requires the recipient to both keep that personal information confidential and not use it for any purpose except performing the contract.</p>
            <p>We share your personal information with the following categories of third parties:</p>
            <ul>
            <li>Subsidiaries and affiliates.</li>
            <li>Contractors and service providers.</li>
            <li>Data aggregators.</li>
            <li>Third parties with whom we partner to offer products and services to you.</li>
            </ul>
            <p><strong>DISCLOSURES OF PERSONAL INFORMATION FOR A BUSINESS PURPOSE</strong></p>
            <p>In the preceding 12 months, PrimeView has disclosed the following categories of personal information for a business purpose to the parties identified above:</p>
            <p>Category A: Identifiers.</p>
            <p>Category B: California Customer Records personal information categories.</p>
            <p>Category C: Protected classification characteristics under California or federal law.</p>
            <p>Category D: Commercial information.</p>
            <p>Category F: Internet or other similar network activity.</p>
            <p>Category G: Geolocation data.</p>
            <p><strong>SALES OF PERSONAL INFORMATION</strong></p>
            <p>In the preceding 12 months, PrimeView has not sold personal information.</p>
            <p><strong>YOUR RIGHTS AND CHOICES</strong></p>
            <p>The CCPA provides consumers (California residents) with specific rights regarding their personal information. This section describes your CCPA rights and explains how to exercise those rights.</p>
            <p><strong>ACCESS TO SPECIFIC INFORMATION AND DATA PORTABILITY RIGHTS</strong></p>
            <p>You have the right to request that PrimeView disclose certain information to you about our collection and use of your personal information over the past 12 months. Once we receive and confirm your verifiable consumer request (see Exercising Access, Data Portability, and Deletion Rights), we will disclose to you:</p>
            <ul>
            <li>The categories of personal information we collected about you.</li>
            <li>The categories of sources for the personal information we collected about you.</li>
            <li>Our business or commercial purpose for collecting or selling that personal information.</li>
            <li>The categories of third parties with whom we share that personal information.</li>
            <li>The specific pieces of personal information we collected about you (also called a data portability request).</li>
            <li>If we sold or disclosed your personal information for a business purpose, two separate lists disclosing:</li>
            <ul>
            <li>sales, identifying the personal information categories that each category of recipient purchased; and</li>
            <li>disclosures for a business purpose, identifying the personal information categories that each category of recipient obtained.</li>
            </ul>
            </ul>
            <p><strong>DELETION REQUEST RIGHTS</strong></p>
            <p>You have the right to request that PrimeView delete any of your personal information that we collected from you and retained, subject to certain exceptions. Once we receive and confirm your verifiable consumer request (see Exercising Access, Data Portability, and Deletion Rights), we will delete (and direct our service providers to delete) your personal information from our records, unless an exception applies.</p>
            <p>We may deny your deletion request if retaining the information is necessary for us or our service provider(s) to:</p>
            <ol>
            <li>Complete the transaction for which we collected the personal information, provide a good or service that you requested, take actions reasonably anticipated within the context of our ongoing business relationship with you, or otherwise perform our contract with you.</li>
            <li>Detect security incidents, protect against malicious, deceptive, fraudulent, or illegal activity, or prosecute those responsible for such activities.</li>
            <li>Debug products to identify and repair errors that impair existing intended functionality.</li>
            <li>Exercise free speech, ensure the right of another consumer to exercise their free speech rights, or exercise another right provided for by law.</li>
            <li>Comply with the California Electronic Communications Privacy Act (Cal. Penal Code § 1546 et. seq.).</li>
            <li>Engage in public or peer-reviewed scientific, historical, or statistical research in the public interest that adheres to all other applicable ethics and privacy laws, when the information’s deletion may likely render impossible or seriously impair the research’s achievement, if you previously provided informed consent.</li>
            <li>Enable solely internal uses that are reasonably aligned with consumer expectations based on your relationship with us.</li>
            <li>Comply with a legal obligation.</li>
            <li>Make other internal and lawful uses of that information that are compatible with the context in which you provided it.</li>
            </ol>
            <p><strong>EXERCISING ACCESS, DATA PORTABILITY, AND DELETION RIGHTS</strong></p>
            <p>To exercise the access, data portability, and deletion rights described above, please submit a verifiable consumer request to us by contacting us at:</p>
            <p>PrimeView LLC                      or                    support@primeview.com</p>
            <p>Attn: President/CEO</p>
            <p>1717 N 77th St #4 Scottsdale</p>
            <p>AZ 85257</p>
            <p>480-800-4688</p>
            <p>Only you, or a person registered with the California Secretary of State that you authorize to act on your behalf, may make a verifiable consumer request related to your personal information. You may also make a verifiable consumer request on behalf of your minor child.</p>
            <p>You may only make a verifiable consumer request for access or data portability twice within a 12-month period. The verifiable consumer request must:</p>
            <ul>
            <li>Provide sufficient information that allows us to reasonably verify you are the person about whom we collected personal information or an authorized representative.</li>
            <li>Describe your request with sufficient detail that allows us to properly understand, evaluate, and respond to it.</li>
            </ul>
            <p>We cannot respond to your request or provide you with personal information if we cannot verify your identity or authority to make the request and confirm the personal information relates to you.</p>
            <p>Making a verifiable consumer request does not require you to create an account with us. We will only use personal information provided in a verifiable consumer request to verify the requestor’s identity or authority to make the request.</p>
            <p><strong>RESPONSE TIMING AND FORMAT</strong></p>
            <p>We endeavor to respond to a verifiable consumer request within forty-five (45) days of its receipt. If we require more time (up to 90 days), we will inform you of the reason and extension period in writing.</p>
            <p>If you have an account with us, we will deliver our written response to that account. If you do not have an account with us, we will deliver our written response by mail or electronically, at your option.</p>
            <p>Any disclosures we provide will only cover the 12-month period preceding the verifiable consumer request’s receipt. The response we provide will also explain the reasons we cannot comply with a request, if applicable. For data portability requests, we will select a format to provide your personal information that is readily useable and should allow you to transmit the information from one entity to another entity without hindrance.</p>
            <p>We do not charge a fee to process or respond to your verifiable consumer request unless it is excessive, repetitive, or manifestly unfounded. If we determine that the request warrants a fee, we will tell you why we made that decision and provide you with a cost estimate before completing your request.</p>
            <p><strong>PERSONAL INFORMATION SALES OPT-OUT AND OPT-IN RIGHTS</strong></p>
            <p>If you are 16 years of age or older, you have the right to direct us to not sell your personal information at any time (the “right to opt-out”). We do not sell the personal information of consumers we actually know are less than 16 years of age, unless we receive affirmative authorization (the “right to opt-in”) from either the consumer who is between 13 and 16 years of age, or the parent or guardian of a consumer who is between 13 and 16 years of age. Consumers who opt-in to personal information sales may opt-out of future sales at any time.</p>
            <p><strong>NON-DISCRIMINATION</strong></p>
            <p>We will not discriminate against you for exercising any of your CCPA rights. Unless permitted by the CCPA, we will not:</p>
            <ul>
            <li>Deny you goods or services.</li>
            <li>Charge you different prices or rates for goods or services, including through granting discounts or other benefits, or imposing penalties.</li>
            <li>Provide you a different level or quality of goods or services.</li>
            <li>Suggest that you may receive a different price or rate for goods or services or a different level or quality of goods or services.</li>
            </ul>
            <p>However, we may offer you certain financial incentives permitted by the CCPA that can result in different prices, rates, or quality levels. Any CCPA-permitted financial incentive we offer will reasonably relate to your personal information’s value and contain written terms that describe the program’s material aspects. Participation in a financial incentive program requires your prior opt-in consent, which you may revoke at any time.</p>
            <p><strong>OTHER CALIFORNIA PRIVACY RIGHTS</strong></p>
            <p>California’s “Shine the Light” law (Civil Code Section § 1798.83) permits users of our Site that are California residents to request certain information regarding our disclosure of personal information to third parties for their direct marketing purposes. To make such a request, please write or email to us at:</p>
            <p>PrimeView LLC                      or                    support@primeview.com</p>
            <p>Attn: President/CEO</p>
            <p>1717 N 77th St #4 Scottsdale</p>
            <p>AZ 85257</p>
            <p>480-800-4688</p>
            <p><strong>CHANGES TO OUR PRIVACY NOTICE</strong></p>
            <p>PrimeView reserves the right to amend this privacy notice at our discretion and at any time. When we make changes to this privacy notice, we will post the updated notice on the Site and update the notice’s effective date. <strong>Your continued use of our site following the posting of changes constitutes your acceptance of such changes.</strong></p>
            <p><strong>CONTACT INFORMATION</strong></p>
            <p>If you have any questions or comments about this notice, the ways in which PrimeView collects and uses your information described below and in the Privacy Policy, your choices and rights regarding such use, or wish to exercise your rights under California law, please do not hesitate to contact us at:</p>
            <p>PrimeView LLC                      or                    support@primeview.com</p>
            <p>Attn: President/CEO</p>
            <p>1717 N 77th St #4 Scottsdale</p>
            <p>AZ 85257</p>
            <p>480-800-4688</p>
            ";
        
        /** Insert GDPR Content */
        $queryI2 = "
			INSERT INTO `" . $wpdb->prefix . "zn_cookie_content` (`Gdpr_Page_Content`, `Ccpa_Page_Content`, `Privacy_Policy_Link`, `Cookie_Policy_Link`, `Terms_and_Condition_Link`, `Message`, `Allow_Button`, `Deny_Button`) VALUES
			('".$gdpr_content."', '".$ccpa_content."', '', '', '', 'This website uses cookies to ensure you get the best experience on our website.', 'Allow cookies', 'Decline')
            ";

        /** Insert GDPR Layout */
        $queryI3 = "
			INSERT INTO `" . $wpdb->prefix . "zn_cookie_layout` (`Position`, `Layout`, `Color_Banner`, `Color_Banner_Text`, `Color_Button`, `Color_Button_Text`, `Compliance`) VALUES
			( 'default', 'default', '#0D9D96', '#FFFFFF', '#FFFFFF', '#0D9D96', 'default')
            ";

        $email_approved = "<p>Hello {requester},</p><p>Your {type_of_request} has been approved. Please wait for two (2) to three (3) days to process your request. You will receive another email after your request has been processed. Thank you.</p>";
        $email_disapproved = "<p>Hello {requester},</p><p>Sorry but your request has been disapproved. Please contact the site support for more details.</p>";

        /** Insert Default Settings */
        $queryI4 = "
			INSERT INTO `" . $wpdb->prefix . "zn_cookie_settings` (`Email_Approved_Template`, `Email_Dispproved_Template`, `Email_Receiver`) VALUES
			( '" . $email_approved . "', '" . $email_disapproved . "', '')
            ";

        $sql = $db->query($query);
        $sql1 = $db->query($query1);
        $sql2 = $db->query($query2);
        $sql3 = $db->query($query3);
        $sql4 = $db->query($query4);
        $sql5 = $db->query($query5);
        $sql6 = $db->query($queryI1);
        $sql7 = $db->query($queryI2);
        $sql8 = $db->query($queryI3);
        $sql9 = $db->query($queryI4);

        if ($sql && $sql1 && $sql2 && $sql3 && $sql4 && $sql5) {
            if ($sql6 && $sql7 && $sql8 && $sql9) {
                return true;
            } else {
                die("MYSQL Error : " . mysqli_error($db));
            }
        } else {
            die("MYSQL Error : " . mysqli_error($db));
            // DROP TABLE `wp_zn_cookie_requester`,`wp_zn_cookie_type_request`, `wp_zn_cookie_request`, `wp_zn_cookie_content`, `wp_zn_cookie_layout`, `wp_zn_cookie_settings`
        }
    }
}
