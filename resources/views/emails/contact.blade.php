<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Inquiry</title>
</head>

<body style="margin: 0;font-family: 'Arial';">
    
    <table style="width: 667px;margin: auto;border-collapse: collapse;">
        <thead>
            <tr>
                <td style="font-size: 20px;font-family: 'Arial';font-weight: 700;padding: 20px;background: #fafafa;">
                    Contact Inquiry
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding: 20px;border: 1px solid #fafafa;">
                    <p style="margin: 0;line-height: 1.7;font-family: 'Arial';margin-bottom: 10px;">
                        <strong>Dear Admin,</strong>
                    </p>
                    <table style="width: 100%;border-collapse: collapse;">
                        <tbody>
                            <tr>
                                <td style="padding: 5px 10px;border: 1px solid rgb(0 0 0 / 10%);font-size: 13px;font-weight: 700;">
                                    Full Name
                                </td>
                                <td style="padding: 5px 10px;border: 1px solid rgb(0 0 0 / 10%);font-size: 13px;">
                                    {{ $fullName }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 10px;border: 1px solid rgb(0 0 0 / 10%);font-size: 13px;font-weight: 700;">
                                    Email
                                </td>
                                <td style="padding: 5px 10px;border: 1px solid rgb(0 0 0 / 10%);font-size: 13px;">
                                    {{ $email }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 10px;border: 1px solid rgb(0 0 0 / 10%);font-size: 13px;font-weight: 700;">
                                    Message
                                </td>
                                <td style="padding: 5px 10px;border: 1px solid rgb(0 0 0 / 10%);font-size: 13px;">
                                    {{ $contact_message }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
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

