# Use the official Python image from Docker Hub
FROM python:3.8-slim

# Set the working directory
WORKDIR /app

# Install system dependencies and Tesseract OCR
RUN apt-get update && \
    apt-get install -y tesseract-ocr && \
    apt-get install -y libglib2.0-0 && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Copy requirements.txt and install dependencies
COPY requirements.txt . 
RUN pip install --no-cache-dir -r requirements.txt

# Copy the rest of the application code
COPY app.py .

# Expose the application port
EXPOSE 5000

# Command to run the application
CMD ["python", "app.py"]
