 <!-- Admin --A Member Has Cancelled Their Subscription  -->
    <div style="max-width: 640px; margin-left: auto; margin-right: auto; width: 100%; background-color: #fcfcfc; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); border-radius: 8px; overflow: hidden; margin-top: 32px; border-top: 4px solid #CC0000">
        
        <!-- Header Area (Clean Gray/White) -->
         <!-- background-color: #f9f9f9; -->
    <?php if( $logo_url ) { ?>
        <div style="padding: 24px; padding-bottom: 0; color: #333333; text-align: center;">
            <!-- Site Logo Placeholder -->
            <img src="<?php echo $logo_url; ?>" alt="Alqimi Logo" style="width: 160px; display: block; margin: 0 auto 8px auto; border-radius: 4px;">
        </div>
    <?php } ?>
        <!-- Body Content -->
        <div style="padding: 32px;">
            <!-- Highlighted Membership Level -->
            <div style="text-align: center; margin-bottom: 24px;">
                <p style="font-size: 18px; color: #555555; font-weight: 500; margin-top: 0; margin-bottom: 8px;">Dear Admin,</p>
                <h2 style="font-size: 26px; font-weight: 700; color: #CC0000; margin-top: 0; margin-bottom: 0; display: inline-block; padding-bottom: 4px;">
                    MEMBERSHIP CANCELLATION ALERT
                </h2>
                <h2 style="font-size: 24px; font-weight: 700; color: #111827; margin-top: 0; margin-bottom: 0; display: inline-block; border-bottom: 3px solid #CC0000; padding-bottom: 4px;">
                    A Member Has Cancelled Their Subscription
                </h2>
            </div>
            
            <p style="color: #4b5563; margin-bottom: 32px; text-align: center;">
                Please find the details of the new user registration below for your records and verification:
            </p>

            <!-- User Data Block -->
            <div style="background-color: #f7f7f7; padding: 20px; border: 1px solid #e0e0e0; border-radius: 6px; margin-bottom: 32px;">
                <p style="font-size: 16px; margin: 0 0 10px 0;">
                    <strong style="color: #333333; display: inline-block; width: 160px;">User Name:</strong> <?php echo esc_html($name); ?>
                </p>
                <p style="font-size: 16px; margin: 0 0 10px 0;">
                    <strong style="color: #333333; display: inline-block; width: 160px;">User Email:</strong> <?php echo esc_html($email); ?>
                </p>
                <p style="font-size: 16px; margin: 0 0 10px 0;">
                    <strong style="color: #333333; display: inline-block; width: 160px;">Cancelled Level:</strong> <span style="font-weight: 700; text-transform: uppercase; color: #CC0000;"><?php echo get_the_title($membership_id); ?></span>
                </p>
                <p style="font-size: 16px; margin: 0;">
                    <strong style="color: #333333; display: inline-block; width: 160px;">Effective End Date:</strong> <?php echo current_time('d-m-Y'); ?>
                </p>
            </div>

            <p style="font-size: 13px; color: #6b7280; margin-top: 24px; margin-bottom: 0; text-align: center;">
                Please follow up to determine the reason for cancellation if needed.
            </p>
        </div>
        
        <!-- Footer - Plugin Name and Links updated -->
        <div style="background-color: #333333; padding: 16px; text-align: center; font-size: 11px; color: #cccccc; border-top: 1px solid #444444; display: flex;  justify-content: space-between !important;">
            <p style="margin: 0;">&copy; 2025 <?php get_bloginfo('name'); ?>. All rights reserved.</p>
            <p style="margin-top: 0; margin-bottom: 0;">
                <a href="<?php echo get_site_url(); ?>/support" style="color: #aaaaaa; text-decoration: underline;">Support Center</a> | 
                <a href="<?php echo get_site_url(); ?>/privacy-policy" style="color: #aaaaaa; text-decoration: underline;">Privacy Policy</a>
            </p>
        </div>
    </div>