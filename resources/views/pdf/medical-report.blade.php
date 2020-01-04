<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>

    <style>
        body{
            padding: 0;
            margin: 0;
        }

        p, h1, h2, h4, h5{
            margin: 0;
            margin-bottom: 8px;
        }

        main{
            padding: 10px;
        }

        .hospital-address{
            text-align: center;
        }

        .hospital-address p{
            margin-bottom: 0;
        }

        hr{
            border: none;
            border-top: 1px solid #959292;
        }

        hr.bordered{
            border-top-style: dashed;
        }

        table{
            width: 100%;
        }

        table.inner-table{
            width: auto;
        }
    </style>

</head>
<body>

<main>
    <header>
        <table>
            <tbody>
            <tr>
                <small>Private and confidential</small>
            </tr>
            <tr>
                <td class="hospital-address">
                    <h2>Asceso Hospitals</h2>
                    <p><small>543/B,</small></p>
                    <p><small>Colombo road</small></p>
                    <p><small>Kandy</small></p>
                    <p><small>Tel: 081-1122322, 081-1122323</small></p>
                    <p><small>Fax: 081-1122333</small></p>
                    <p><small>Email: support@asceso.com</small></p>
                </td>
            </tr>
            </tbody>
        </table>
    </header>

    <hr>

    <h4>Report name</h4>
    <br>

    <div>
        <h5>Patient details</h5>

        <table>
            <tbody>
            <tr>
                <td>
                    <table class="inner-table">
                        <tr>
                            <td>Name: </td>
                            <td>{{$report->patient->name}}</td>
                        </tr>
                        <tr>
                            <td>NIC: </td>
                            <td>{{$report->patient->nic}}</td>
                        </tr>
                        <tr>
                            <td>Gender: </td>
                            <td>{{$report->patient->gender == 'M' ? 'Male' : 'Female'}}</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table class="inner-table">
                        <tr>
                            <td>Date of birth: </td>
                            <td>{{$report->patient->dob->format('Y-m-d')}}</td>
                        </tr>
                        <tr>
                            <td>Age: </td>
                            <td>{{now()->diffInYears($report->patient->dob)}}</td>
                        </tr>
                        <tr>
                            <td>Contact: </td>
                            <td>{{$report->patient->contact}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <hr class="bordered">
    <br><br><br>

    <div class="results">
        <h4>Results</h4>
        <p>{{$report->patient->results}}</p>
    </div>

    <br><br>

    <div class="remarks">
        <h4>Remarks</h4>
        <p>{{$report->patient->remarks}}</p>
    </div>

    <br><br><br>

    <div>
        <table>
            <tbody>
            <tr>
                <td>
                    <p>Tested at: {{$report->tested_at->format('Y-m-d h:i:s A')}}</p>
                </td>
                <td>
                    <p>Tested at: {{$report->tested_by->name}}</p>
                </td>
                <td>
                    <p>...........................................</p>
                    <p>Signature</p>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <hr class="bordered">

    <footer>

        <table>
            <tbody>
            <tr>
                <td>
                    <small>Generated at: {{date('Y-m-d h:i:s A')}}</small>
                </td>
            </tr>
            </tbody>
        </table>

    </footer>

</main>
</body>
</html>
