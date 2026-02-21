<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;
use Visualbuilder\EmailTemplates\Models\EmailTemplate;

class EmailTemplateSeeder extends Seeder
{
    public function run()
    {
        $emailTemplates = [
            [
                'key' => 'user-welcome',
                'from' => ['email' => config('mail.from.address'), 'name' => config('mail.from.name')],
                'name' => 'User Welcome Email',
                'title' => 'Welcome to ##config.app.name##',
                'subject' => 'Welcome to ##config.app.name##',
                'preheader' => 'Lets get you started',
                'content' => '<p>Dear ##user.name##,</p>
                                <p>Thanks for registering with ##config.app.name##.</p>
                                <p>If you need any assistance please contact our customer services team ##config.email-templates.customer-services.email## who will be happy to help.</p>
                                <p>Kind Regards<br>
                                ##config.app.name##</p>',
                'team_id' => Team::first()->id,

            ],
            [
                'key' => 'user-request-reset',
                'from' => ['email' => config('mail.from.address'), 'name' => config('mail.from.name')],
                'name' => 'User Request Password Reset',
                'title' => 'Reset your password',
                'subject' => '##config.app.name## Password Reset',
                'preheader' => 'Reset Password',
                'content' => "<p>Hello ##user.name##,</p>
                                <p>You are receiving this email because we received a password reset request for your account.</p>
                                <div>{{button url='##tokenUrl##' title='Change My Password'}}</div>
                                <p>If you didn't request this password reset, no further action is needed. However if this has happened more than once in a short space of time, please let us know.</p>
                                <p>We'll never ask for your credentials over the phone or by email and you should never share your credentials</p>
                                <p>If you’re having trouble clicking the 'Change My Password' button, copy and paste the URL below into your web browser:</p>
                                <p><a href='##tokenUrl##'>##tokenUrl##</a></p>
                                <p>Kind Regards,<br>##config.app.name##</p>",
                'team_id' => Team::first()->id,
            ],
            [
                'key' => 'user-password-reset-success',
                'from' => ['email' => config('mail.from.address'), 'name' => config('mail.from.name')],
                'name' => 'User Password Reset',
                'title' => 'Password Reset Success',
                'subject' => '##config.app.name## password has been reset',
                'preheader' => 'Success',
                'content' => '<p>Dear ##user.name##,</p>
                                <p>Your password has been reset.</p>
                                <p>Kind Regards,<br>##config.app.name##</p>',
                'team_id' => Team::first()->id,
            ],
            [
                'key' => 'user-locked-out',
                'from' => ['email' => config('mail.from.address'), 'name' => config('mail.from.name')],

                'name' => 'User Account Locked Out',
                'title' => 'Account Locked',
                'subject' => '##config.app.name## account has been locked',
                'preheader' => 'Oops!',
                'content' => '<p>Dear ##user.name##,</p>
                                <p>Sorry your account has been locked out due to too many bad password attempts.</p>
                                <p>Please contact our customer services team on ##config.email-templates.customer-services.email## who will be able to help</p>
                                 <p>Kind Regards,<br>##config.app.name##</p>',
                'team_id' => Team::first()->id,

            ],
            [
                'key' => 'user-verify-email',
                'from' => ['email' => config('mail.from.address'), 'name' => config('mail.from.name')],

                'name' => 'User Verify Email',
                'title' => 'Verify your email',
                'subject' => 'Verify your email with ##config.app.name##',
                'preheader' => 'Gain Access Now',
                'content' => "<p>Dear ##user.name##,</p>
                                <p>Your receiving this email because your email address has been registered on ##config.app.name##.</p>
                                <p>To activate your account please click the button below.</p>
                                <div>{{button url='##verificationUrl##' title='Verify Email Address'}}</div>
                                <p>If you’re having trouble clicking the 'Verify Email Address' button, copy and paste the URL below into your web browser:</p>
                                <p><a href='##verificationUrl##'>##verificationUrl##</a></p>
                                <p>Kind Regards,<br>##config.app.name##</p>",
                'team_id' => Team::first()->id,
            ],
            [
                'key' => 'user-verified',
                'from' => ['email' => config('mail.from.address'), 'name' => config('mail.from.name')],
                'name' => 'User Verified',
                'title' => 'Verification Success',
                'subject' => 'Verification success for ##config.app.name##',
                'preheader' => 'Verification success for ##config.app.name##',
                'content' => '<p>Hi ##user.name##,</p>
                                <p>Your email address ##user.email## has been verified on ##config.app.name##</p>
                                <p>Kind Regards,<br>##config.app.name##</p>',
                'team_id' => Team::first()->id,
            ],
            [
                'key' => 'user-login',
                'from' => ['email' => config('mail.from.address'), 'name' => config('mail.from.name')],
                'name' => 'User Logged In',
                'title' => 'Login Success',
                'subject' => 'Login Success for ##config.app.name##',
                'preheader' => 'Login Success for ##config.app.name##',
                'content' => '<p>Hi ##user.name##,</p>
                                <p>You have been logged into ##config.app.name##.</p>
                                <p>If this was not you please contact: </p>
                                <p>You can disable this email in your account notification preferences.</p>
                                <p>Kind Regards,<br>##config.app.name##</p>',
                'team_id' => Team::first()->id,
            ],
            // Order Email Templates
            [
                'key' => 'order-paid',
                'from' => ['email' => config('mail.from.address'), 'name' => config('mail.from.name')],
                'name' => 'Order Payment Confirmed',
                'title' => 'Order ##order.order_number## - Payment Confirmed',
                'subject' => 'Order ##order.order_number## - Payment Confirmed',
                'preheader' => 'Thank you for your order',
                'content' => '<p>Dear ##customerName##,</p>
                                <p>Great news! Your payment for order ##order.order_number## has been successfully processed. Your order is now being prepared for shipment.</p>
                                
                                <h3>Order Details</h3>
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr><td><strong>Order Number:</strong></td><td>##order.order_number##</td></tr>
                                    <tr><td><strong>Payment Status:</strong></td><td>Paid</td></tr>
                                    <tr><td><strong>Order Status:</strong></td><td>##order.order_status##</td></tr>
                                    <tr><td><strong>Payment Method:</strong></td><td>##order.payment_method##</td></tr>
                                    <tr><td><strong>Total Amount:</strong></td><td>##orderTotal##</td></tr>
                                    <tr><td><strong>Order Date:</strong></td><td>##order.created_at##</td></tr>
                                </table>
                                
                                <h4>Items Ordered:</h4>
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr style="background: #f0f0f0;">
                                        <th style="padding: 10px; text-align: left;">Product</th>
                                        <th style="padding: 10px; text-align: center;">Quantity</th>
                                        <th style="padding: 10px; text-align: right;">Price</th>
                                        <th style="padding: 10px; text-align: right;">Total</th>
                                    </tr>
                                    ##orderItems##
                                    <tr>
                                        <td colspan="3" style="padding: 10px; text-align: right; border-top: 2px solid #ddd;"><strong>Total:</strong></td>
                                        <td style="padding: 10px; text-align: right; border-top: 2px solid #ddd;"><strong>##orderTotal##</strong></td>
                                    </tr>
                                </table>
                                
                                <div style="text-align: center; margin: 30px 0;">
                                    {{button url=\'##orderUrl##\' title=\'View Order Details\'}}
                                </div>
                                
                                <p><strong>What happens next?</strong></p>
                                <ul>
                                    <li>Your order will be processed and shipped within 1-2 business days</li>
                                    <li>You\'ll receive a shipping confirmation email with tracking information</li>
                                    <li>You can download your invoice from your order details page</li>
                                </ul>
                                
                                ##orderNotes##
                                
                                <p>Thank you for choosing ##config.app.name##!</p>
                                <p>If you have any questions, please contact our support team.</p>',
                'team_id' => Team::first()->id,
            ],
            [
                'key' => 'order-shipped',
                'from' => ['email' => config('mail.from.address'), 'name' => config('mail.from.name')],
                'name' => 'Order Shipped',
                'title' => 'Order ##order.order_number## - Shipped',
                'subject' => 'Order ##order.order_number## - Shipped',
                'preheader' => 'Your order is on its way',
                'content' => '<p>Dear ##customerName##,</p>
                                <p>Great news! Your order ##order.order_number## has been shipped and is on its way to you.</p>
                                
                                <h3>Shipping Details</h3>
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr><td><strong>Order Number:</strong></td><td>##order.order_number##</td></tr>
                                    <tr><td><strong>Shipping Date:</strong></td><td>##order.shipped_at##</td></tr>
                                    <tr><td><strong>Tracking Number:</strong></td><td>##trackingNumber##</td></tr>
                                    <tr><td><strong>Carrier:</strong></td><td>##carrier##</td></tr>
                                </table>
                                
                                <div style="text-align: center; margin: 30px 0;">
                                    {{button url=\'##trackingUrl##\' title=\'Track Your Package\'}}
                                </div>
                                
                                <p>You can expect delivery within ##deliveryDays## business days.</p>
                                <p>Thank you for choosing ##config.app.name##!</p>',
                'team_id' => Team::first()->id,
            ],
            [
                'key' => 'order-cancelled',
                'from' => ['email' => config('mail.from.address'), 'name' => config('mail.from.name')],
                'name' => 'Order Cancelled',
                'title' => 'Order ##order.order_number## - Cancelled',
                'subject' => 'Order ##order.order_number## - Cancelled',
                'preheader' => 'Your order has been cancelled',
                'content' => '<p>Dear ##customerName##,</p>
                                <p>Your order ##order.order_number## has been cancelled.</p>
                                
                                <h3>Cancellation Details</h3>
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr><td><strong>Order Number:</strong></td><td>##order.order_number##</td></tr>
                                    <tr><td><strong>Cancellation Date:</strong></td><td>##order.cancelled_at##</td></tr>
                                    <tr><td><strong>Reason:</strong></td><td>##cancellationReason##</td></tr>
                                    <tr><td><strong>Refund Status:</strong></td><td>##refundStatus##</td></tr>
                                </table>
                                
                                ##refundDetails##
                                
                                <p>If you have any questions about this cancellation, please contact our support team.</p>
                                <p>Thank you for your understanding.</p>',
                'team_id' => Team::first()->id,
            ],
        ];

        EmailTemplate::factory()
            ->createMany($emailTemplates);
    }
}
