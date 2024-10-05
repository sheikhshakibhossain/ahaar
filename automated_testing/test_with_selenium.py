import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC


# Start the WebDriver
service = Service("/usr/bin/chromedriver")
driver = webdriver.Chrome(service=service)
driver.get("http://127.0.0.1/ahaar/donor_login.php")
time.sleep(2)


# Input the destination details
email = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.XPATH, "/html/body/div/form/div[1]/input")))
email.click()
email.send_keys("shakib221@gmail.com")
time.sleep(1)


password = driver.find_element(By.XPATH, "/html/body/div/form/div[2]/input")
password.click()
password.send_keys("meaw")
time.sleep(1)


# Click login button
login_btn = WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.XPATH, "/html/body/div/form/div[4]/input")))
login_btn.click()
time.sleep(5)


# driver.get("http://127.0.0.1/ahaar/donor/make_donation.php")
donate_btn = WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.XPATH, "/html/body/div[1]/div[3]/h4/a[1]/button")))
donate_btn.click()
time.sleep(2)


food_name = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.XPATH, "/html/body/div/div[2]/form/div[1]/div[1]/input")))
food_name.click()
food_name.send_keys("Vapa Pitha")
time.sleep(1)

quantity = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.XPATH, "/html/body/div/div[2]/form/div[1]/div[2]/input")))
quantity.click()
quantity.send_keys("300")
time.sleep(1)

location = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.XPATH, "/html/body/div/div[2]/form/div[1]/div[3]/input")))
location.click()
location.send_keys("Sayeed Nagar")
time.sleep(1)


# Interact with the date picker
datepicker = driver.find_element(By.XPATH, "/html/body/div/div[2]/form/div[1]/div[4]/input")
datepicker.click()


# Select a specific date (adjust if needed based on the calendar structure)
datepick = WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.XPATH, "/html/body/div/div[2]/form/div[1]/div[4]/input")))
datepick.click()
datepick.send_keys("2024-10-29 22:44:00")


postal_code = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.XPATH, "/html/body/div/div[2]/form/div[1]/div[5]/input")))
postal_code.click()
postal_code.send_keys("1200")
time.sleep(1)

submit_btn = WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.XPATH, "/html/body/div/div[2]/form/div[2]/input")))
submit_btn.click()
time.sleep(5)