# VultrHackathon

Project Overview
The Medical Chatbot is an innovative solution aimed at solving the common issue faced by many patients—struggling to read their doctor's handwriting on prescriptions. This project enables users to upload a photo of their handwritten prescription, and it extracts the details of the prescribed medicines using Optical Character Recognition (OCR). The system then returns relevant information about the medicines, helping users better understand their prescriptions.

Why this Project?
In the medical field, it's common for doctors to write prescriptions by hand. Unfortunately, the handwriting is often unclear, making it difficult for patients to read and interpret the prescribed medications. This can lead to confusion, incorrect dosages, and even potential medical errors. This project seeks to address this problem by providing a way for patients to upload their doctor's prescription and automatically extract the medicine details.

By leveraging OCR technology, the Medical Chatbot can quickly analyze handwritten prescriptions and offer clear, understandable details about the prescribed drugs, making healthcare more accessible and reducing the burden on patients.

About the project

Laravel Application

The Laravel app serves as the main user interface for the chatbot. It handles user interactions, such as receiving prescription images and displaying the extracted information.
It is responsible for managing user sessions, input forms, and communication with the flask app to process the prescriptions.
The app is built using the Laravel PHP framework and runs on an Apache web server.

Flask OCR Application (Backend)

The Flask app is responsible for processing the uploaded images and extracting text using OCR. 

After extracting the text, it returns the parsed details to the Laravel frontend, which displays them to the user.
The Flask app is built using Python and relies on various dependencies like OpenCV and OCR methods for image processing and text recognition.

Technologies Used
Laravel (PHP) for the frontend application.
Flask (Python) for the backend OCR processing.
Docker for containerization of both applications.
Apache for serving the Laravel app.

Deployment:
1. Pull the flask-ocr-app and laravel-app image from the Vultr Container Registry
   docker pull sjc.vultrcr.com/chatbot/laravel-app:latest
   docker pull sjc.vultrcr.com/chatbot/flask-ocr-app:latest

2. Setup a network using docker
   docker network create chatbot-network

3. Run the images:
   docker run -d -p 8000:80 --name laravel-app --network chatbot-network sjc.vultrcr.com/chatbot/laravel-app
   docker run -d -p 5000:5000 --name flask-ocr-app --network chatbot-network sjc.vultrcr.com/chatbot/flask-ocr-app

Access the web app on your host IP: http://<host-ip>:8000
