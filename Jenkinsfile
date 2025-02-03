pipeline {
    agent any

    environment {
        DEPLOY_USER = 'ubuntu'  // Change to your AWS server's username
        DEPLOY_HOST = '3.208.22.205'  // Change to your AWS server's IP
        DEPLOY_DIR = '/var/www/html/'  // Directory where your site is hosted
        GIT_REPO = 'git@github.com:Shivachaithanya26/Emeals-test.git'  // Use SSH URL
        SSH_CREDENTIALS_ID = 'jenkins-ssh-key-id'  // Jenkins stored SSH Key
    }

    stages {
        stage('Checkout Code') {
            steps {
                sshagent(['PC SSH']) {
                    sh 'sudo git clone --depth=1 $GIT_REPO repo || (cd repo && sudo git pull origin main)'
                }
            }
        }

        stage('Deploy to Server') {
            steps {
                script {
                    sshagent(['jenkins-ssh-key-id']) {
                        sh """
                            ssh -o StrictHostKeyChecking=no $DEPLOY_USER@$DEPLOY_HOST <<EOF
                            cd $DEPLOY_DIR
                            sudo git pull origin main
                            sudo systemctl restart nginx
                            EOF
                        """
                    }
                }
            }
        }
    }
}
