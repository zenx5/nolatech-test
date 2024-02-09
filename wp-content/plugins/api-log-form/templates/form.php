<?php

    $form_name = get_option('log_form_name','');

?>
<h1>Form Settings</h1>

<div>
    <table>
        <tr>
            <th style="width:200px;">Form Name</th>
            <td>
                <input type="text" value="<?=$form_name?>" name="log-form-name"/>
            </td>
        </tr>
        <tr>
            <td>
                <button id="save-log-form">Guardar</button>
            </td>
        </tr>
        

    </table>
<script>
    jQuery('#save-log-form').click(async ()=>{
        const name = jQuery('input[name="log-form-name"]').val()
        const response = await fetch(ajaxurl, {
            method:'post',
            headers:{
                'Content-Type':'application/x-www-form-urlencoded'
            },
            body:[
                `action=save_log_form`,
                `log_form_name=${name}`
            ].join('&')
        })
        const result = await response.text();
        if( result ) {
            if( sessionStorage.getItem('z5_debug') ) {
                console.log( result )
            } else {
                document.location.reload();
            }
        }
    })
</script>