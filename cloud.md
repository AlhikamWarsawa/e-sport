# GCP Deployment Guide

This document describes a **concise** process to deploy the **e-sport** project on Google Cloud Platform using a Compute Engine VM, Docker Compose, and Ngrok for demo purposes.

---

## Prerequisites

* Active GCP project with billing enabled
* Terraform installed locally
* gcloud CLI authenticated (`gcloud auth login`)
* Ngrok account (with credit)
* GitHub repository access
* Enable Compute Engine API

---

## 1. Provision VM with Terraform

From the `terraform` directory:

```bash
terraform init
terraform apply
```

Confirm with:

```text
yes
```

Save the **external VM IP** from the output.

---

## 2. SSH into the VM

Recommended method:

```bash
gcloud compute ssh mentor-demo-vm --zone=asia-southeast2-a
```

---

## 3. Install Docker

```bash
sudo apt update
sudo apt install -y docker.io
sudo systemctl enable docker
sudo systemctl start docker
```

Allow current user to run Docker without sudo:

```bash
sudo usermod -aG docker $USER
exit
```

Re-login to the VM after logout.

---

## 4. Install Docker Compose (v2 – Manual)

```bash
sudo mkdir -p /usr/local/lib/docker/cli-plugins
sudo curl -SL https://github.com/docker/compose/releases/download/v2.29.7/docker-compose-linux-x86_64 \
  -o /usr/local/lib/docker/cli-plugins/docker-compose
sudo chmod +x /usr/local/lib/docker/cli-plugins/docker-compose
```

Verify:

```bash
docker compose version
```

---

## 5. Clone Project Repository

```bash
git clone https://github.com/AlhikamWarsawa/e-sport.git
cd e-sport
```

---

## 6. Application Setup (Read This First)

Before running Docker Compose, **follow the Laravel setup instructions in the project `README.md`**, including:

* Environment configuration (`.env`)
* Application key generation
* Database initialization / migration
* Any required permissions or storage setup

Skipping the README setup steps may cause the containers to start successfully but the application to fail at runtime.

---

## 7. Test the Application

From inside the VM:

```bash
curl http://localhost:8000
```

Optionally access from browser:

```text
http://<VM_EXTERNAL_IP>:8000
```

---

## 8. Expose with Ngrok for Demo Only

```bash
ngrok config add-authtoken <NGROK_TOKEN>
ngrok http 8000
```
