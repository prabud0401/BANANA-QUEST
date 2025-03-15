from flask import Flask, render_template, request, redirect, url_for, session, jsonify
import json
import requests
from datetime import datetime

app = Flask(__name__)
app.secret_key = 'banana_secret_123'
app.config['PERMANENT_SESSION_LIFETIME'] = 3600  # 1 hour session

# Initialize users.json
try:
    with open('users.json', 'r') as f:
        users = json.load(f)
except FileNotFoundError:
    users = {}

BANANA_API = "http://marcconrad.com/uob/banana/api.php"

DIFFICULTIES = {
    'easy': {'min': 1, 'max': 10, 'time': 60},
    'medium': {'min': 10, 'max': 50, 'time': 45},
    'hard': {'min': 50, 'max': 100, 'time': 30}
}

@app.route('/')
def home():
    if 'email' not in session:
        return redirect(url_for('login'))
    return redirect(url_for('game'))

@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        email = request.form['email']
        password = request.form['password']
        if users.get(email) and users[email]['password'] == password:
            session['email'] = email
            session.permanent = True
            return redirect(url_for('index'))
        return render_template('login.html', error="Invalid credentials")
    return render_template('login.html')

@app.route('/register', methods=['GET', 'POST'])
def register():
    if request.method == 'POST':
        email = request.form['email']
        if email in users:
            return render_template('register.html', error="Email already exists")
        users[email] = {
            'username': request.form['username'],
            'password': request.form['password'],
            'scores': [],
            'high_score': 0,
            'last_score': 0
        }
        with open('users.json', 'w') as f:
            json.dump(users, f)
        return redirect(url_for('login'))
    return render_template('register.html')

@app.route('/index')
def index():
    if 'email' not in session:
        return redirect(url_for('login'))
    return render_template('index.html')

@app.route('/game')
def game():
    if 'email' not in session:
        return redirect(url_for('login'))
    
    difficulty = session.get('difficulty', 'easy')
    params = {
        'out': 'json',
        **DIFFICULTIES[difficulty]
    }
    
    try:
        response = requests.get(BANANA_API, params=params)
        data = response.json()
        return render_template('game.html',
                             question_img=data['question'],
                             solution=data['solution'],
                             difficulty=difficulty,
                             time_limit=DIFFICULTIES[difficulty]['time'],
                             user=users[session['email']])
    except Exception as e:
        return render_template('error.html', error="Failed to load game")

@app.route('/submit-score', methods=['POST'])
def submit_score():
    if 'email' not in session:
        return jsonify({'status': 'error'})
    
    data = request.get_json()
    score = int(data['score'])
    user = users[session['email']]
    user['last_score'] = score
    
    if score > user['high_score']:
        user['high_score'] = score
    
    user['scores'].append({
        'score': score,
        'timestamp': datetime.now().isoformat(),
        'difficulty': session.get('difficulty', 'easy')
    })
    
    with open('users.json', 'w') as f:
        json.dump(users, f)
    
    return jsonify({'status': 'success'})

@app.route('/profile')
def profile():
    if 'email' not in session:
        return redirect(url_for('login'))
    user = users[session['email']]
    return render_template('profile.html', user=user)

@app.route('/leaderboard')
def leaderboard():
    sorted_users = sorted(users.values(), key=lambda x: x['high_score'], reverse=True)
    return render_template('leaderboard.html', users=sorted_users[:10])

@app.route('/logout')
def logout():
    session.pop('email', None)
    return redirect(url_for('login'))

if __name__ == '__main__':
    app.run(debug=True)