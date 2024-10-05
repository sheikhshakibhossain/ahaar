from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

from selenium.webdriver.chrome.service import Service
from selenium.webdriver.chrome.options import Options



# Start the WebDriver
service = Service("/usr/bin/chromedriver")
driver = webdriver.Chrome(service=service)
driver.get("https://eticket.railway.gov.bd/")
time.sleep(2)


# Click the agree button
agree_btn = WebDriverWait(driver, 10).until(
    EC.element_to_be_clickable((By.XPATH, "/html/body/app-root/app-home/app-disclaimer-modal/div/div/div[2]/div[2]/button"))
)
agree_btn.click()


# Input the destination details
dest_from = WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.ID, "dest_from")))
dest_from.click()
dest_from.send_keys("Dhaka")
time.sleep(1)


dest_to = driver.find_element(By.ID, "dest_to")
dest_from.click()
dest_to.send_keys("Chattogram")
time.sleep(1)


# Interact with the date picker
datepicker = driver.find_element(By.XPATH, "/html/body/app-root/app-home/div/div/app-search-widget/div/div[3]/div[1]/form/div/div[2]/div[1]/div/img")
datepicker.click()


# Select a specific date (adjust if needed based on the calendar structure)
datepick = WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.XPATH, "/html/body/div/table/tbody/tr[4]/td[6]/a")))
datepick.click()


# Select class (Snigdha in this case)
choose_class = Select(WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.ID, "choose_class"))))
choose_class.select_by_value("SNIGDHA")
time.sleep(1)


# Click the search button
search_btn = WebDriverWait(driver, 10).until(EC.element_to_be_clickable((By.XPATH, "/html/body/app-root/app-home/div/div/app-search-widget/div/div[3]/div[1]/form/div/div[3]/div[2]/div/button")))
search_btn.click()
