import os
import re

files = [
    'resources/views/barang/create.blade.php',
    'resources/views/barang/edit.blade.php',
    'resources/views/pelanggan/create.blade.php',
    'resources/views/pelanggan/edit.blade.php',
    'resources/views/pemasok/create.blade.php',
    'resources/views/pemasok/edit.blade.php',
    'resources/views/pembelian/create.blade.php',
    'resources/views/pembelian/edit.blade.php',
    'resources/views/penjualan/create.blade.php',
    'resources/views/penjualan/edit.blade.php',
    'resources/views/user/create.blade.php',
    'resources/views/user/edit.blade.php'
]

# Replacement rules
# 1. Inputs/Textareas/Selects
input_old = r'class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300(?: transition-all)?"'
input_new = 'class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300"'

# 2. Labels
label_old = r'class="text-sm font-semibold text-gray-700 mb-1.5"'
label_new = 'class="block text-xs font-semibold text-gray-500 mb-2"'

# 3. Primary Buttons
primary_button_old = r'class="px-10 py-3 bg-teal-600 text-white rounded-xl text-sm font-bold hover:bg-teal-700 transition-all shadow-lg shadow-teal-200"'
primary_button_new = 'class="px-10 py-3 bg-teal-600 text-white font-bold rounded-xl shadow-sm hover:bg-teal-700 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300"'

# Specific variation for primary button in some files (px-6 py-2)
primary_button_small_old = r'class="px-6 py-2 bg-teal-600 text-white rounded-xl text-sm font-semibold shadow-md shadow-teal-600/20 hover:bg-teal-700 hover:-translate-y-0.5 transition-all duration-300"'
# The target is still the same primary button style as requested by the user
primary_button_small_new = 'class="px-10 py-3 bg-teal-600 text-white font-bold rounded-xl shadow-sm hover:bg-teal-700 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300"'

# 4. Secondary Buttons
secondary_button_old = r'class="px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-50 transition-colors shadow-sm hover:bg-gray-200 transition-colors"'
secondary_button_new = 'class="px-6 py-3 bg-gray-100 text-gray-600 font-semibold rounded-xl hover:bg-gray-200 transition-colors"'

# Specific variation for secondary button (px-6 py-2)
secondary_button_small_old = r'class="px-6 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-50 transition-colors shadow-sm"'
secondary_button_small_new = 'class="px-6 py-3 bg-gray-100 text-gray-600 font-semibold rounded-xl hover:bg-gray-200 transition-colors"'

# 5. Alpine.JS Dropdowns
# Trigger Button (must match input styling but keep flex layout)
alpine_trigger_old = r'class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm flex items-center justify-between focus:ring-2 focus:ring-teal-500 transition-all"'
alpine_trigger_new = 'class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 transition-all duration-300 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 hover:border-gray-300 flex items-center justify-between"'

# Individual Options
alpine_option_old = r':class="selected === option(\.val)? \? \'bg-teal-50 text-teal-600 font-bold\' : \'text-gray-600 hover:bg-gray-50\'"'
alpine_option_new = r':class="selected === option\1 ? \'text-teal-600 font-bold\' : \'\'"'
# Wait, the rule for Individual Options is: "px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between group hover:bg-teal-50 hover:text-teal-700 text-gray-600"
# And Selected Option: "text-teal-600 font-bold"

# Let's refine Alpine options
alpine_option_base_old = r'class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between group"'
alpine_option_base_new = 'class="px-4 py-2.5 text-sm cursor-pointer transition-colors flex items-center justify-between group hover:bg-teal-50 hover:text-teal-700 text-gray-600"'

for file_path in files:
    if not os.path.exists(file_path):
        print(f"Skipping {file_path}, not found.")
        continue
    
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Apply replacements
    content = re.sub(input_old, input_new, content)
    content = re.sub(label_old, label_new, content)
    content = re.sub(primary_button_old, primary_button_new, content)
    content = re.sub(primary_button_small_old, primary_button_small_new, content)
    content = re.sub(secondary_button_old, secondary_button_new, content)
    content = re.sub(secondary_button_small_old, secondary_button_small_new, content)
    content = re.sub(alpine_trigger_old, alpine_trigger_new, content)
    content = re.sub(alpine_option_base_old, alpine_option_base_new, content)
    content = re.sub(alpine_option_old, alpine_option_new, content)

    # Specific check for Title Case on labels
    # This is a bit complex with regex, but we can try to find label tags and capitalize their content
    def capitalize_label(match):
        full_tag = match.group(0)
        label_content = match.group(2)
        # Title case if it's all uppercase or just needs a boost
        # But user said "Ensure the text is in Title Case or Sentence Case"
        # Most are already "Nama Produk", so we might not need to do much unless they are "NAMA PRODUK"
        return full_tag.replace(label_content, label_content.strip().title())

    # content = re.sub(r'(<label[^>]*>)([^<]+)(</label>)', capitalize_label, content)

    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(content)
    print(f"Updated {file_path}")
