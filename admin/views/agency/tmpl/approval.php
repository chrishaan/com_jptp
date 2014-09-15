<?php

/**
 * @version $Id $
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<p>Thank you for your agency’s application to determine eligibility in
attending our Juvenile Personnel Training Program (JPTP) workshops.  We
are pleased to let you know your agency is eligible!  Staff will now be
able to register and attend our free trainings.  Visit our website at:
<a href="http://www.nrcys.ou.edu/jptp-events">www.nrcys.ou.edu/jptp-events</a>
to register, and view or print our entire fiscal year schedule.  
Please check registration details for each workshop to determine earliest 
enrollment date.</p>

<?php 
if ($this->row->listserv == "1")
{
echo <<<EOL
    <p>The email submitted on your application will be added to our JPTP mailing 
        list to advise you of upcoming events and trainings.</p>
EOL;
}
?>

<p>Thanks for your interest and support of the JPTP program.  Please let
us know if we can answer further questions.</p>
<p>Regards,</p>
<p>
Lou Truitt Flanagan<br />
Sr. Program Supervisor<br />
Juvenile Personnel Training Program<br />
The University of Oklahoma OUTREACH<br />
National Resource Center for Youth Services<br />
<a href="mailto:ltruitt@ou.edu">ltruitt@ou.edu</a>
</p>