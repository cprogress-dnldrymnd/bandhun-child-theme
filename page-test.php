<?php
get_header();


 $user_id = get_current_user_id();
//  update_user_meta($user_id, 'is_sponsor', true);
//                     update_user_meta($user_id, 'is_sponsor_payment_id', '');
//                     update_user_meta($user_id, 'is_sponsor_plan_start_date', '');
//                     update_user_meta($user_id, 'is_sponsor_plan_end_date', '');
//                     update_user_meta($user_id, 'is_sponsor_plan_id', '');
//                     update_user_meta($user_id, 'is_sponsor_plan_name', '');
//                     update_user_meta($user_id, 'is_sponsor_price_id', '');
//                     update_user_meta($user_id, 'is_sponsor_plan_status', '');
update_user_meta($user_id, 'price_id', '');
update_user_meta($user_id, 'plan_name', '');
update_user_meta($user_id, 'plan_id', '');
update_user_meta($user_id, 'plan_end_date', '');
update_user_meta($user_id, 'plan_start_date', '');
update_user_meta($user_id, 'is_sponsor_price_id', '');
update_user_meta($user_id, 'plan_status', '');
                    ?>

<?php
get_footer();
?>