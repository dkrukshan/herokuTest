import numpy as np
from flask import Flask, request, jsonify, render_template
import pickle

app = Flask(__name__)
model = pickle.load(open('model.pkl', 'rb'))
heart_model = pickle.load(open('heart_model.pkl', 'rb'))
stress_model = pickle.load(open('stress_model.pkl', 'rb'))
sleep_model = pickle.load(open('sleep_model.pkl', 'rb'))
step_model = pickle.load(open('step_model.pkl', 'rb'))
bmi_model = pickle.load(open('bmi_model.pkl', 'rb'))

@app.route('/')
def home():
    return render_template('index.html')

@app.route('/predict', methods=['POST'])
def predict():
    int_features = [int(x) for x in request.form.values()]
    final_features = [np.array(int_features)]
    prediction = model.predict(final_features)
    output = round(prediction[0], 2)
    return render_template('index.html', prediction_text='Employee Salary should be $ {}'.format(output))

@app.route('/prd_api', methods=['POST'])
def prd_api():
    experience = int(request.form['experience'])
    test_score = int(request.form['test_score'])
    interview_score = int(request.form['interview_score'])
    prediction = model.predict([[experience, test_score, interview_score]])
    output = prediction[0]
    return jsonify(output)

@app.route('/heart_rate_api', methods=['POST'])
def heart_rate_api():
    heart_rate = int(request.form['heart_rate'])
    prediction = heart_model.predict([[heart_rate]])
    output = prediction[0]
    return jsonify(output)

@app.route('/health_check_api', methods=['POST'])
def health_check_api():
    heart_rate = int(request.form['heart_rate'])
    stress = int(request.form['stress'])
    sleep = int(request.form['sleep'])
    step = int(request.form['step'])
    height = int(request.form['height'])
    weight = int(request.form['weight'])
    bmi = int(weight / height / height * 10000)

    heart_state_prediction = heart_model.predict([[heart_rate]])
    stress_state_prediction = stress_model.predict([[stress]])
    sleep_state_prediction = sleep_model.predict([[sleep]])
    step_state_prediction = step_model.predict([[step]])
    bmi_state_prediction = bmi_model.predict([[bmi]])
    # list = [heart_state_prediction[0]]
    # list.insert(1, stress_state_prediction[0])
    # list.insert(2, sleep_state_prediction[0])
    # list.insert(3, step_state_prediction[0])
    # list.insert(4, bmi_state_prediction[0])

    data = [{k: v} for k, v in
            zip(["heart state", "stress state", "sleep state", "step state", "bmi state"],
                [heart_state_prediction[0], stress_state_prediction[0], sleep_state_prediction[0],
                 step_state_prediction[0], bmi_state_prediction[0]])]
    return jsonify({"health status": data})
    # return jsonify(list)

if __name__ == "__main__":
    app.run(debug=True)
