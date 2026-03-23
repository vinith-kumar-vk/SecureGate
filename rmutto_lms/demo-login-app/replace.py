import os
import glob
import re

dir_path = 'resources/views/auth/'
files = glob.glob(dir_path + '*.blade.php')

old_pattern = r'<button\s+class=[\"\']category-dropdown[\"\'].*?</button>'

new_block = """<a href="{{ route('category') }}" class="category-select-btn">
                    Categories
                    <div class="category-select-arrows">
                        <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
                        <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </div>
                </a>"""

for filepath in files:
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()
    
    if '<button class="category-dropdown">' in content:
        new_content = re.sub(old_pattern, new_block, content, flags=re.DOTALL)
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print(f'Updated {filepath}')
