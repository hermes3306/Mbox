sudo apt-get install ssmtp -y
sudo apt-get install mailutils -y
sudo cp ssmtp.conf /etc/ssmtp
sudo cp revaliases /etc/ssmtp
echo "Test Email" | mail -s "Test Email" nice9uy@hotmail.com
