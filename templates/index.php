<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Health Analysis</title>
    <link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Arimo' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Hind:300' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ url_for('static', filename='style.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
</head>

<body>
    <div class="login">
        <br>
        <h1>Health Analysis</h1>
        <form>
            <label>Height (cm):</label>
            <input type="text" name="height" placeholder="Height" required="required" id="Height" /><br>

            <label>Weight (kg):</label>
            <input type="text" name="weight" placeholder="Weight" required="required" id="Weight" /><br>

            <label>Heart Rate (bpm):</label>
            <input type="text" name="heart_rate" placeholder="Heart Rate" required="required" id="Heart" /><br>

            <label>Stress Level (%):</label>
            <input type="text" name="stress_level" placeholder="Stress Level" required="required" id="Stress" /><br>

            <label>Sleep Score (%):</label>
            <input type="text" name="sleep_score" placeholder="Sleep Score" required="required" id="Sleep" /><br>

            <label>Step Count:</label>
            <input type="text" name="step_count" placeholder="Step Count" required="required" id="Step" /><br><br>

            <button type="button" class="btn btn-primary btn-block btn-large" id="btnsubmit">Predict</button>
        </form>
        <br>
        <label id="lbl_heart_state" class="label2">Heart State</label><br>
        <label id="lbl_stress_state" class="label2">Stress State</label><br>
        <label id="lbl_sleep_state" class="label2">Sleep State</label><br>
        <label id="lbl_step_state" class="label2">Step State</label><br>
        <label id="lbl_bmi_state" class="label2">BMI State</label><br>
        <label id="lbl_medical_state" class="label2">Medical State</label><br>
        <br>

    </div>
</body>

</html>

<script>
    $(document).ready(function() {
        $('#btnsubmit').click(function() {
            //             document.getElementById("output").value = 'clicked';
            var height = $('#Height').val();
            var weight = $('#Weight').val();
            var heart_rate = $('#Heart').val();
            var stress = $('#Stress').val();
            var Sleep = $('#Sleep').val();
            var Step = $('#Step').val();
            $.ajax({
                url: "https://healthpredictapp.herokuapp.com/health_check_api",
                method: "POST",
                data: {
                    height: height,
                    weight: weight,
                    heart_rate: heart_rate,
                    stress: stress,
                    sleep: Sleep,
                    step: Step
                },
                dataType: "JSON",
                success: function(data) {
                    var heart_state = data.data[0].heart_state;
                    var stress_state = data.data[1].stress_state;
                    var sleep_state = data.data[2].sleep_state;
                    var step_state = data.data[3].step_state;
                    var bmi_state = data.data[4].bmi_state;

                    var heart_state_response = 'Heart State: ' + heart_state;
                    var stress_state_response = 'Stress State: ' + stress_state;
                    var sleep_state_response = 'Sleep State: ' + sleep_state;
                    var step_state_response = 'Step State: ' + step_state;
                    var bmi_state_response = 'BMI State: ' + bmi_state;

                    document.getElementById('lbl_heart_state').innerHTML = heart_state_response;
                    document.getElementById('lbl_stress_state').innerHTML = stress_state_response;
                    document.getElementById('lbl_sleep_state').innerHTML = sleep_state_response;
                    document.getElementById('lbl_step_state').innerHTML = step_state_response;
                    document.getElementById('lbl_bmi_state').innerHTML = bmi_state_response;
                }
            })
        });
    });
</script>