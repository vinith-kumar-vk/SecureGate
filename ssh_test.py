import paramiko
import sys

def run_ssh_commands():
    hostname = "securegate.tekquora.in"
    username = "vinithkr"
    password = "vinithkr"
    
    try:
        ssh = paramiko.SSHClient()
        ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
        ssh.connect(hostname, username=username, password=password, timeout=10)
        
        commands = [
            "ls -la /home/tekquora-securegate/htdocs/securegate.tekquora.in",
            "ls -la /home/tekquora-securegate/htdocs/securegate.tekquora.in/laravel-backend/public",
        ]
        
        for cmd in commands:
            print(f"--- Running: {cmd} ---")
            stdin, stdout, stderr = ssh.exec_command(cmd)
            out = stdout.read().decode('utf-8')
            err = stderr.read().decode('utf-8')
            print("STDOUT:", out)
            if err:
                print("STDERR:", err)
        
        ssh.close()
    except Exception as e:
        print(f"SSH Error: {e}")

if __name__ == "__main__":
    run_ssh_commands()
