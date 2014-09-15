<?php
/**
 * @version $Id:  $
 */
//no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.html.html.behavior');
JHTML::_('behavior.mootools');

?>

<h1>The Juvenile Personnel Training Program of the National Resource Center for Youth Services</h1>
<h2>Agency Application</h2>
<p>To qualify as a participating agency in The University of Oklahoma Juvenile Personnel Training Program, the following criteria must be met:</p>
<ul>
    <li>be an Oklahoma public or nonprofit social service agency or alternative education program,</li>
    <li>have a major emphasis on children and youth, and</li>
    <li>employ three or more staff.</li>
</ul>

<form action="index.php?option=com_jptp" method="post" name="agency_application" id="agency_application">
    <fieldset>
        <legend>Agency Information</legend>
        <ul>
            <li>
                <label for="name">Agency Name</label>
                <input type="text" name="name" id="name" value="<?php echo JRequest::getString('name'); ?>" /> 
            </li>
            <li>
                <label for="address">Address</label>
                <input type="text" name="address" id="address" value="<?php echo JRequest::getString('address'); ?>" />
            </li>
            <li>
                <label for="address">Address 2 <em>(optional)</em></label>
                <input type="text" name="address2" id="address2" value="<?php echo JRequest::getString('address2'); ?>" />
            </li>            
            <li>
                <label for="address">City</label>
                <input type="text" name="city" id="city" value="<?php echo JRequest::getString('city'); ?>" />
            </li>
            <li>
                <label for="address">State</label>
                <select name="state" id="address2">
                    <option value="OK">Oklahoma</option>
                </select>
            </li> 
            <li>
                <label for="address">Zip</label>
                <input type="text" name="zip" id="zip" value="<?php echo JRequest::getString('zip'); ?>" />
            </li>
            <li>
                <label for="address">Agency Phone</label>
                <input type="text" name="phone" id="phone" value="<?php echo JRequest::getString('phone'); ?>" />
            </li>
            <li>
                <label for="address">Agency Fax</label>
                <input type="text" name="fax" id="fax" value="<?php echo JRequest::getString('fax'); ?>" />
            </li>
        </ul>
    </fieldset>
    <fieldset>
        <legend>Director</legend>
        <ul>
            <li>
                <label for="director_first_name">First Name</label>
                <input type="text" name="director_first_name" id="director_first_name" value="<?php echo JRequest::getString('director_first_name'); ?>" />
            </li>
            <li>
                <label for="director_last_name">Last Name</label>
                <input type="text" name="director_last_name" id="director_last_name" value="<?php echo JRequest::getString('director_last_name'); ?>" />
            </li>
            <li>
                <label for="director_email">Email</label>
                <input type="text" name="director_email" id="director_email" value="<?php echo JRequest::getString('director_email'); ?>" />
            </li>
            <li>
                <fieldset>
                    <legend>Can we add you to our JPTP listserv?</legend>
                    <?php echo $this->listserv; ?>
                </fieldset>
            </li>
        </ul>
    </fieldset>
    <fieldset>
        <legend>Agency Details</legend>
        <ul>
            <li>
                <label for="services" class="textarea_label">What services does your agency provide?</label>
                <textarea name="services" id="services"><?php echo JRequest::getString('services'); ?></textarea>
            </li>
            <li>
                <fieldset>
                    <legend>Are children and youth a focus of your services?</legend>
                    <?php echo $this->youth_focus; ?>
                </fieldset>
            </li>
            <li>
                <label for="youth_percent">What percent?</label>
                <input type="text" name="youth_percent" id="youth_percent" value="<?php echo JRequest::getVar('youth_percent'); ?>" />
            </li>
            <li>
                <fieldset>
                <legend>Is your agency:</legend>
                <?php echo $this->type; ?>
                </fieldset>
            </li>
            <li>
                <label for="funding_sources" class="textarea_label">What are your funding sources?</label>
                <textarea name="funding_sources" id="funding_sources"><?php echo JRequest::getString('funding_sources'); ?></textarea>                
            </li>
            <li>
                <label for="primary_clientele" class="textarea_label">Who are your primary clientele and the sources of your referrals?</label>
                <textarea name="primary_clientele" id="primary_clientele"><?php echo JRequest::getString('primary_clientele'); ?></textarea>                
            </li>
            <li>
                <label for="annual_clientele">How many people do you serve per year?</label>
                <input type="text" name="annual_clientele" id="annual_clientele" value="<?php echo JRequest::getVar('annual_clientele'); ?>" />
            </li>
            <li>
                <label for="staff_count">How many people are on staff?</label>
                <input type="text" name="staff_count" id="staff_count" value="<?php echo JRequest::getVar('staff_count'); ?>" />
            </li>
            <li>
                <label for="staff_education" class="textarea_label">What are the staff's education levels?</label>
                <textarea name="staff_education" id="staff_education"><?php echo JRequest::getString('staff_education'); ?></textarea>
            </li>
            <li>
                <label for="networking_agencies" class="textarea_label">If you network with other local agencies, please identify them: <em>(optional)</em></label>
                <textarea name="networking_agencies" id="networking_agencies"><?php echo JRequest::getString('networking_agencies'); ?></textarea>
            </li> 
            <li>
                <label for="comments" class="textarea_label">Comments? <em>(optional)</em></label>
                <textarea name="comments" id="comments"><?php echo JRequest::getString('comments'); ?></textarea>
            </li>             
        </ul>
    </fieldset>
    <fieldset>
        <div align="center">
            <?php echo JHTML::_('form.token'); ?>
            <input type="hidden" name="controller" value="agencyapplication" />
            <input type="hidden" name="task" value="save" />
            <input type="hidden" name="Itemid" value="<?php echo JRequest::getInt('Itemid', '') ?>" />
            <button type="submit"><?php echo JText::_('Submit'); ?></button>
        </div>
    </fieldset>    
</form>
