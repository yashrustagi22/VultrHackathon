from flask import Flask, request, jsonify
import pytesseract
import cv2
import numpy as np

app = Flask(__name__)


@app.route('/predict', methods=['POST'])
def predict():
    # Check if an image file is provided
    if 'image' not in request.files:
        return jsonify({"error": "No image file provided."}), 400
    

    image_file = request.files['image']

    # Read the image using OpenCV
    file_bytes = np.asarray(bytearray(image_file.read()), dtype=np.uint8)
    image = cv2.imdecode(file_bytes, cv2.IMREAD_COLOR)

    # Convert the image to grayscale
    gray_image = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)

    # Use Tesseract to extract text from the image
    extracted_text = pytesseract.image_to_string(gray_image)

    return jsonify({"text": extracted_text})

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
