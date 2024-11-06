pipeline {
    agent any

    environment {
        COMPOSE_FILE = 'compose.yml'
    }

    stages {
        stage('Clone Repository') {
            steps {
                git branch: 'main', url: 'https://github.com/your-repo-url.git'
            }
        }

        stage('Build Docker Images') {
            steps {
                script {
                    sh 'docker compose -f $COMPOSE_FILE build'
                }
            }
        }

        stage('Start Services') {
            steps {
                script {
                    sh 'docker compose -f $COMPOSE_FILE up -d'
                }
            }
        }

        stage('Run Composer Install') {
            steps {
                script {
                    sh 'docker compose -f $COMPOSE_FILE exec app composer install'
                }
            }
        }

        // stage('Run Tests') {
        //     steps {
        //         script {
        //             sh 'docker compose -f $COMPOSE_FILE exec app php artisan test'
        //         }
        //     }
        // }
    }

    post {
        always {
            script {
                sh 'docker compose -f $COMPOSE_FILE down -v'
            }
        }
    }
}