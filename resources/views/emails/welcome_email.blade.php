@php $userName = $email_data['name'] ?? 'there'; @endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to <strong>TravaiQ</strong>!</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f8f9fa;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f8f9fa;">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <!-- Main container -->
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" style="background-color: #ffffff; max-width: 600px;">
                    
                    <!-- Header -->
                   <tr>
                        <td align="center" style="background: linear-gradient(90deg, #4f46e5, #0ea5e9); padding: 40px 24px;">
                            <!-- <img src="https://TravaiQ.com/public/TravaiQlogo.png" alt="TravaiQ Logo" width="72" height="72" style="border-radius: 50%; background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1);"> -->
                            <h1 style="color: #fff; font-size: 28px; margin: 16px 0 4px; font-weight: 700;">Hey {{ $userName }}  👋</h1>
                            <h3 style="color: #e0f2fe; font-size: 16px; margin: 0;">Welcome to <strong>TravaiQ</strong></h3>
                        </td>
                    </tr>
                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px;">
                            
                            <!-- Greeting -->
                            <!-- <p style="margin: 0 0 15px 0; font-size: 18px; color: #333333;">Hi traveler,</p> -->
                            
                            <p style="margin: 0 0 10px 0; color: #7c3aed; font-size: 16px;">Welcome to the <strong>TravaiQ</strong> community! 🎉</p>
                            
                            <p style="margin: 0 0 30px 0; font-size: 16px; color: #333333; font-weight: 500;">
                                We have been working really hard to get <strong>TravaiQ</strong> to this place, and are unbelievably 
                                excited for you to plan your next adventure with us 🤩
                            </p>
                            
                            <!-- Travel Smart Section -->
                            <table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 40px 0;">
                                <tr>
                                    <td align="center">
                                        <img src="https://travaiq.com/public/email_back.png" alt="Travel Smart" style="width: 100%; max-width: 600px; height: auto; border-radius: 12px; display: block;">
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Features -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 30px 0;">
                                <tr>
    <td>
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-bottom: 20px;">
            <tr>
                <td width="30" style="vertical-align: top; padding-top: 2px;">
                    <span style="color: #28a745; font-size: 18px; font-weight: bold;">✓</span>
                </td>
                <td style="vertical-align: top;">
                    <p style="margin: 0 0 5px 0; font-weight: bold; color: #333333;">Getting started:</p>
                    <p style="margin: 0; color: #333333; line-height: 1.6;">
                        Tell <strong>TravaiQ</strong> your destination, budget, and interests to get a personalized travel plan. 
                    </p>
                </td>
            </tr>
        </table>
        
      <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-bottom: 20px;">
    <tr>
        <td width="30" style="vertical-align: top; padding-top: 2px;">
            <span style="color: #28a745; font-size: 18px; font-weight: bold;">✓</span>
        </td>
        <td style="vertical-align: top;">
            <p style="margin: 0 0 5px 0; font-weight: bold; color: #333333;">View  your plan:</p>
            <p style="margin: 0; color: #333333; line-height: 1.6;">
                After using the "Plan My Trip" feature, TravaiQ will generate a complete itinerary with places to visit, where to stay, and safety tips.
            </p>
        </td>
    </tr>
</table>

<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-bottom: 20px;">
    <tr>
        <td width="30" style="vertical-align: top; padding-top: 2px;">
            <span style="color: #28a745; font-size: 18px; font-weight: bold;">🤖</span>
        </td>
        <td style="vertical-align: top;">
            <p style="margin: 0 0 5px 0; font-weight: bold; color: #333333;">AI-powered suggestions:</p>
            <p style="margin: 0; color: #333333; line-height: 1.6;">
                Your itinerary is generated using smart AI — personalized to your destination, interests, and preferences. It's quick, accurate, and designed to make trip planning effortless.
            </p>
        </td>
    </tr>
</table>


    </td>
</tr>

                            </table>
                            
                            <!-- Thank you message -->
                            <p style="margin: 30px 0; color: #333333; line-height: 1.6;">
                                Thanks again for your belief in <strong>TravaiQ</strong>! We hope you enjoy the product.
                                <br><br>
                                Happy traveling!
                            </p>
                            
                            <!-- CTA Section -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 40px 0;">
                                <tr>
                                    <td align="center">
                                        <p style="margin: 0 0 20px 0; color: #666666;">
                                            You can find <strong>TravaiQ</strong> at <a href="https://travaiq.com" style="color: #7c3aed; text-decoration: none;"><strong>TravaiQ.com</strong></a>
                                        </p>
                                        <a href="{{ url('/create-plan') }}" style="display: inline-block; background: linear-gradient(ede9fe, #ede9fe 0%, #7c3aed 100%); background-color: #7c3aed; color: #ffffff; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-size: 16px; font-weight: bold;">Start Planning ✈️</a>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Divider -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 40px 0;">
                                <tr>
                                    <td style="border-top: 1px solid #dddddd;"></td>
                                </tr>
                            </table>
                           
                            
                            <!-- Feedback Section -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f8f9fa; border-radius: 8px; margin: 30px 0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <p style="margin: 0 0 10px 0; font-weight: bold; color: #333333;">Got feedback or a feature request?</p>
                                        <p style="margin: 0 0 15px 0; color: #666666; font-size: 14px;">Help us become your one-stop shop for travel planning</p>
                                        <a href="{{ url('/contact') }}" style="display: inline-block; background-color: #333333; color: #ffffff; padding: 8px 20px; text-decoration: none; border-radius: 20px; font-size: 14px;">Submit form</a>
                                    </td>
                                </tr>
                            </table>
                            
                             <tr>
                        <td align="center" style="padding: 24px; color: #888; font-size: 13px;">
                            &copy; {{ date('Y') }} TravaiQ, All rights reserved. <br>
                            <span style="color: #bbb;">Plan better. Explore smarter. Travel more.</span>
                        </td>
                    </tr>
                            
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>