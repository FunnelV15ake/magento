<?php

class GetresponseIntegration_Getresponse_Block_Adminhtml_Autoresponder extends Mage_Core_Block_Template
{

    protected $campaignDays = array();
    protected $selectedDay = '';

    public function __construct(array $args = array())
    {
        parent::__construct($args);

        $this->campaignDays = $args['campaign_days'];
        if (isset($args['selected_day']))
            $this->selectedDay = $args['selected_day'];
    }

    protected function _toHtml()
    {
        $html = '
            <tr class="details">
                <td class="label"></td>
                <td class="value">
                    <input type="checkbox" name="gr_autoresponder" id="gr_autoresponder" value="1" />
                    <label for="gr_autoresponder" class="inactive">Add to autoresponder sequence</label>
                </td>
            </tr>

            <tr class="details">
                <td class="label"><label>Autoresponder day</label></td>
                <td class="value">
                    <select class="inactive" title="Autoresponder" name="cycle_day" id="cycle_day">
                        <option value="">no autresponders</option>
                    </select>
                </td>
            </tr>
        ';

        $js = "
            <script>
                (function($) {
                    var available_cycles = $.parseJSON('".addslashes(json_encode($this->campaignDays))."');
                    
                    cycles.init(
                        available_cycles,
                        $('#campaign_id'),
                        $('#cycle_day'),
                        $('#gr_autoresponder'),
                        $('label[for=\"gr_autoresponder\"]')
                        ".$this->selectedDay."
                    );
                    
            })(jQuery);
            </script>
        ";

        return $html . ' ' . $js;
    }

}