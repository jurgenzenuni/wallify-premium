import os

folder_path = 'images'  # Specify the path to your folder

# List all files in the folder
files = os.listdir(folder_path)

# Iterate through each file
for file_name in files:
    # Check if the file name starts with a number
    if not file_name[0].isdigit():
        # Construct the full file path
        file_path = os.path.join(folder_path, file_name)
        
        # Delete the file
        os.remove(file_path)
        print(f"Deleted: {file_path}")
