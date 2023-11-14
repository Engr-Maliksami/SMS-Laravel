<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th width="30%"><?php echo $this->lang->line('school'); ?> <?php echo $this->lang->line('name'); ?></th>
            <td><?php echo $email_setting->school_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('email'); ?> <?php echo $this->lang->line('protocol'); ?></th>
            <td><?php echo $email_setting->mail_protocol; ?></td>
        </tr>
         
        <?php if($email_setting->mail_protocol == 'smtp'){ ?>
            <tr>
                <th><?php echo $this->lang->line('smtp'); ?> <?php echo $this->lang->line('host'); ?></th>
                <td><?php echo $email_setting->smtp_host; ?></td>
            </tr> 
            <tr>
                <th><?php echo $this->lang->line('smtp'); ?> <?php echo $this->lang->line('port'); ?></th>
                <td><?php echo $email_setting->smtp_port; ?></td>
            </tr> 
            <tr>
                <th><?php echo $this->lang->line('smtp'); ?> <?php echo $this->lang->line('username'); ?></th>
                <td><?php echo $email_setting->smtp_user; ?></td>
            </tr> 
            <tr>
                <th><?php echo $this->lang->line('smtp'); ?> <?php echo $this->lang->line('password'); ?></th>
                <td><?php echo $email_setting->smtp_pass; ?></td>
            </tr> 
            <tr>
                <th><?php echo $this->lang->line('smtp'); ?> <?php echo $this->lang->line('security'); ?></th>
                <td><?php echo $email_setting->smtp_crypto; ?></td>
            </tr> 
            <tr>
                <th><?php echo $this->lang->line('smtp'); ?> <?php echo $this->lang->line('time_out'); ?></th>
                <td><?php echo $email_setting->smtp_timeout; ?></td>
            </tr>            
        <?php } ?>
        <tr>
            <th><?php echo $this->lang->line('email'); ?> <?php echo $this->lang->line('type'); ?></th>
            <td><?php echo $email_setting->mail_type; ?></td>
        </tr> 
        <tr>
            <th><?php echo $this->lang->line('email'); ?> <?php echo $this->lang->line('char_set'); ?></th>
            <td><?php echo $email_setting->char_set; ?></td>
        </tr> 
        <tr>
            <th><?php echo $this->lang->line('email'); ?> <?php echo $this->lang->line('priority'); ?></th>
            <td><?php echo $email_setting->priority; ?></td>
        </tr> 
        <tr>
            <th><?php echo $this->lang->line('email'); ?> <?php echo $this->lang->line('from'); ?> <?php echo $this->lang->line('name'); ?></th>
            <td><?php echo $email_setting->from_name; ?></td>
        </tr> 
        <tr>
            <th><?php echo $this->lang->line('email'); ?> <?php echo $this->lang->line('from'); ?> <?php echo $this->lang->line('address'); ?></th>
            <td><?php echo $email_setting->from_address; ?></td>
        </tr> 
        
    </tbody>
</table>
