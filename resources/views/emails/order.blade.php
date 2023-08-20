<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thankyou for Contact</title>
</head>

<body style="margin: 0;font-family: 'Arial';">
    
    <table style="width: 667px;margin: auto;border-collapse: collapse;">
        <thead>
            <tr>
                <td style="font-size: 20px;font-family: 'Arial';font-weight: 700;padding: 20px;background: #fafafa;">
                    Order Notification
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding: 20px;border: 1px solid #fafafa;">
                    <p style="margin: 0;line-height: 1.7;font-family: 'Arial';margin-bottom: 10px;">
                        <strong>Hello {{ $fullName }}</strong>
                    </p>
                    <p style="margin: 0;line-height: 1.7;font-family: 'Arial';margin-bottom: 10px;">
                        New order recived check admin panel for more details.
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

