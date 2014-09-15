<?php
/**
 * @version $Id:  $
 */
//no direct access
defined('_JEXEC') or die('Restricted access');

$doc =& JFactory::getDocument();
$doc->addStyleSheet( 'http://' . $_SERVER['SERVER_NAME'] . "/components/com_jptp/assets/calendar.css" );

function dayNames($day, $month, $year) {
    $time = gmmktime(0, 0, 0, $month, $day, $year);
    $day_name = ucfirst(gmstrftime('%A', $time));
    return $day_name;
}

$first_day = 0;  // defines first day of week -  0 is Sunday
$first_of_month = gmmktime(0, 0, 0, $this->req_month, 1, $this->req_year);
list($month_name, $weekday) = explode(',', gmstrftime('%B,%w', $first_of_month));
$weekday = ($weekday + 7 - $first_day) % 7; #adjust for $first_day

$title = $this->prev_link . "&nbsp;&nbsp;";
$title .= htmlentities(ucfirst($month_name)) . '&nbsp;' . $this->req_year;
$title .= "&nbsp;&nbsp;" . $this->next_link;

$prev_year = $this->current_year - 1;
$next_year = $this->current_year + 1;

$first_year = ($this->current_month < 7 ) ? $this->current_year - 1  : $this->current_year;
$second_year = $first_year + 1;

$action = JRoute::_('index.php?option=com_jptp&controller=calendar');

echo "<h1>{$title}</h1>";

echo '<a href="/index.php?option=com_jptp&controller=calendar&layout=list" >List View</a>';

echo <<<EOL
<div id="month_selector">
    <div style="float: left; background-color: wheat;">
        <table style="width: 100%">
            <tr>
                <th colspan="6">  {$first_year} </th>
            </tr>
            <tr>
                <td><a href="{$action}/7/{$first_year}">Jul</a></td>
                <td><a href="{$action}/8/{$first_year}">Aug</a></td>
                <td><a href="{$action}/9/{$first_year}">Sep</a></td>
                <td><a href="{$action}/10/{$first_year}">Oct</a></td>
                <td><a href="{$action}/11/{$first_year}">Nov</a></td>
                <td><a href="{$action}/12/{$first_year}">Dec</a></td>                
            </tr>
        </table>
    </div>
    <div style="float: right; background-color: lightsalmon;">
        <table style="width: 100%">
            <tr>
                <th colspan="6"> {$second_year} </th>
            </tr>
            <tr>
                <td><a href="{$action}/1/{$second_year}">Jan</a></td>
                <td><a href="{$action}/2/{$second_year}">Feb</a></td>
                <td><a href="{$action}/3/{$second_year}">Mar</a></td>
                <td><a href="{$action}/4/{$second_year}">Apr</a></td>
                <td><a href="{$action}/5/{$second_year}">May</a></td>
                <td><a href="{$action}/6/{$second_year}">Jun</a></td>                
            </tr>
        </table>
    </div>    
</div>
<div style="clear: both;"></div>
EOL;
                                        
echo '<table id="calendar" cellspacing="0" cellpadding="0">';

if ($weekday > 0) {
    echo '<tr><td colspan="' . $weekday . '" class="empty_cells" style="height: 100px; ">&nbsp;</td>'; #initial 'empty' days
}

$days_in_month = gmdate('t', $first_of_month);
for ($day = 1; $day <= $days_in_month; $day++, $weekday++) {
    if ($weekday %7 == 0) {
        echo "</tr>\n<tr>";
    }
    
    $key_month = ($this->req_month < 10) ? "0" . $this->req_month : $this->req_month;
    $key_day = ($day < 10) ? "0" . $day : $day;
    $key = $this->req_year . "-" . $key_month . "-" . $key_day;
    
    if (isset($this->events[$key]) and is_array($this->events[$key])) {

        $buffer = '';
        foreach ($this->events[$key] as $event_info) {
            
            $buffer .= '<div class="' . $event_info['class'] .'" ><a href="' . $event_info['info_link'] . '">' . $event_info['title'] . '</a><br />';
            //$buffer .= "<a href=" . $event_info['info_link'] . ">[Learn More]</a>";
            if(!empty($event_info['reg_link'])){
                $buffer .= "<a href=" . $event_info['reg_link'] . ">[Register]</a>";
            }
            $buffer .= "</div>";
            
        }

        echo '<td valign="top" class="'. $event_info['class'] . '_event">';
        echo '<span class="day">' . dayNames($day, $this->req_month, $this->req_year);
        echo ' | ' . $day . '</span>' . $buffer . '</td>' . "\n";
    } else {

        echo '<td valign="top">';
        echo '<span class="day">' . dayNames($day, $this->req_month, $this->req_year) . " | " . $day . '</span><br /></td>' . "\n";
    }
}

if ($weekday % 7 != 0) {
    echo '<td colspan="' . (7 - ($weekday % 7)) . '" class="empty_cells">&nbsp;</td>'; #remaining "empty" days
}

echo "</tr>\n</table>\n</td></tr></table>";

?>