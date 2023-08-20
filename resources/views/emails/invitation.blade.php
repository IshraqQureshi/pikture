<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation to Event</title>
</head>

<body style="margin: 0;font-family: 'Arial';">
    
    <table style="width: 667px;margin: auto;border-collapse: collapse;">
        <thead>
            <tr>
                <td style="font-size: 20px;font-family: 'Arial';font-weight: 700;padding: 20px;background: #fafafa;">
                    Event Invitation
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding: 20px;border: 1px solid #fafafa;">
                    <p style="margin: 0;line-height: 1.7;font-family: 'Arial';margin-bottom: 10px;">
                        <strong>Hello Mr./Ms.</strong>
                    </p>
                    <p style="margin: 0;line-height: 1.7;font-family: 'Arial';margin-bottom: 10px;">
                        You have been invited to the event: {{ $galleryName }}
                    </p>
                    <p style="margin: 10px 0 20px;line-height: 1.7;font-family: 'Arial';">
                        Please click the button below to sign up with that email: {{ $email }}
                    </p>
                    <a href="{{ url('/register') }}?invitaion_key={{ $invitaion_key }}&email={{ $email }}" target="_blank" style="display: inline-block;text-decoration: none;background: #37ac2e;padding: 7px 20px;color: #fff;border-radius: 4px;text-transform: uppercase;letter-spacing: 2px;">
                        Register
                    </a>
                    <p style="margin: 20px 0 10px;line-height: 1.7;font-family: 'Arial';">
                        If you need assistance, our team is here to help. Contact us at <a href="mailto:support@pikture.fr" style="color: #000;font-weight: 700;">support@pikture.fr</a>.
                    </p>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td style="padding: 20px;background: #fafafa;">
                    <p style="margin: 0;line-height: 1.7;font-family: 'Arial';">
                        Best regards,
                    </p>
                    <p style="margin: 0;line-height: 1.7;font-family: 'Arial';">
                        <strong>The Pikture Team</strong>
                    </p>
                    <p>
                        <img width="150px" src="{{ url('/storage/19caj7Khh26reLoBujXwiZHTpOpIACFGEnlg3Fxq.png') }}" alt="Pikture">
                    </p>
                </td>
            </tr>
        </tfoot>
    </table>

</body>
</html>

