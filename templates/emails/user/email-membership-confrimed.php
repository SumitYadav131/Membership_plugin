
 <!-- Membership Confrimed -->
    <div style="max-width: 640px; margin-left: auto; margin-right: auto; width: 100%; background-color: #fcfcfc; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); border-radius: 8px; overflow: hidden; margin-top: 32px; border-top: 4px solid #008000">
        
        <!-- Header Area (Clean Gray/White) -->
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
                <p style="font-size: 18px; color: #555555; font-weight: 500; margin-top: 0; margin-bottom: 8px;">Dear <?php echo esc_html($name); ?>,</p>
                <h2 style="font-size: 26px; font-weight: 700; color: #111827; margin-top: 0; margin-bottom: 0; display: inline-block; padding-bottom: 4px;">
                    Membership Confrimed
                </h2>
                <h2 style="font-size: 26px; font-weight: 700; text-transform: uppercase; color: #008000; margin-top: 0; margin-bottom: 0; display: inline-block; border-bottom: 3px solid #333333; padding-bottom: 4px;">
                         <?php echo get_the_title($membershipid); ?> LEVEL ACCESS GRANTED
                </h2>
            </div>
            
            
            <p style="color: #4b5563; margin-bottom: 32px; text-align: center;">
                Thank you for choosing the **<?php echo get_the_title($membershipid); ?>** level. Your payment has been successfully processed, and your account features have been instantly upgraded. You now have access to our most advanced tools and dedicated support.
            </p>

            <!-- Call to Action - Professional Blue -->
            <a href="<?php echo get_site_url(); ?>/my-account" style="display: block; text-transform: uppercase; text-align: center; padding: 14px; background-color: #008000; color: #ffffff; font-weight: 700; font-size: 16px; border-radius: 6px; box-shadow: 0 4px 10px #00800045; text-decoration: none;">
                Go to Your Dashboard
            </a>
        </div>
        
        <!-- Footer -->
        <div style="background-color: #333333; padding: 16px; text-align: center; font-size: 11px; color: #cccccc; border-top: 1px solid #444444;">
            <p style="margin: 0;">&copy; <?php echo date('Y'); ?> <?php echo esc_html($site_title); ?>. All rights reserved.</p>
        </div>
    </div>
