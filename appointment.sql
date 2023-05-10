CREATE TABLE Patient (
  patient_id INT PRIMARY KEY,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE Appointment (
  ap_id INT PRIMARY KEY,
  ap_time TIME NOT NULL,
  ap_date DATE NOT NULL,
  doctor_name VARCHAR(255) NOT NULL,
  doctor_id INT NOT NULL,
  patient_id INT NOT NULL,
  FOREIGN KEY (doctor_id) REFERENCES Doctor(doctor_id),
  FOREIGN KEY (patient_id) REFERENCES Patient(patient_id)
);

CREATE TABLE Doctor(
doctor_id INT PRIMARY KEY,
doctor_name VARCHAR(255) NOT NULL
);