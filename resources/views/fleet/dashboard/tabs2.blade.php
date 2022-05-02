<div class="-mt-6 mb-3">
  <div class="sm:hidden">
    <label for="tabs" class="sr-only">Select a tab</label>
    <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
    <select id="tabs" name="tabs" class="block w-full focus:ring-blue-500 focus:border-blue-500 border-gray-300 rounded-md">
      <option>My Account</option>

      <option>Company</option>

      <option selected>Team Members</option>

      <option>Billing</option>
    </select>
  </div>
  <div class="hidden sm:block">
    <div class="border-b border-gray-200">
      <nav class="-mb-px flex space-x-8" aria-label="Tabs">
        <a href="{{ route('fleet.dashboard.itv') }}" class="{{ request()->is('*/itv') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
          <svg xmlns="http://www.w3.org/2000/svg" class="{{ request()->is('*/itv') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} -ml-0.5 mr-2 h-5 w-5" fill="currentColor" stroke="currentColor" stroke-width="2" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M152.1 38.16C161.9 47.03 162.7 62.2 153.8 72.06L81.84 152.1C77.43 156.9 71.21 159.8 64.63 159.1C58.05 160.2 51.69 157.6 47.03 152.1L7.029 112.1C-2.343 103.6-2.343 88.4 7.029 79.03C16.4 69.66 31.6 69.66 40.97 79.03L63.08 101.1L118.2 39.94C127 30.09 142.2 29.29 152.1 38.16V38.16zM152.1 198.2C161.9 207 162.7 222.2 153.8 232.1L81.84 312.1C77.43 316.9 71.21 319.8 64.63 319.1C58.05 320.2 51.69 317.6 47.03 312.1L7.029 272.1C-2.343 263.6-2.343 248.4 7.029 239C16.4 229.7 31.6 229.7 40.97 239L63.08 261.1L118.2 199.9C127 190.1 142.2 189.3 152.1 198.2V198.2zM224 96C224 78.33 238.3 64 256 64H480C497.7 64 512 78.33 512 96C512 113.7 497.7 128 480 128H256C238.3 128 224 113.7 224 96V96zM224 256C224 238.3 238.3 224 256 224H480C497.7 224 512 238.3 512 256C512 273.7 497.7 288 480 288H256C238.3 288 224 273.7 224 256zM160 416C160 398.3 174.3 384 192 384H480C497.7 384 512 398.3 512 416C512 433.7 497.7 448 480 448H192C174.3 448 160 433.7 160 416zM0 416C0 389.5 21.49 368 48 368C74.51 368 96 389.5 96 416C96 442.5 74.51 464 48 464C21.49 464 0 442.5 0 416z"/></svg>
          <span>ITV</span>
        </a>

        <a href="{{ route('fleet.dashboard.tacograph') }}" class="{{ request()->is('*/tacograph') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm" aria-current="page">
          <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" stroke="currentColor" stroke-width="2" class="{{ request()->is('*/tacograph') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} -ml-0.5 mr-2 h-5 w-5" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M576 64H64C28.8 64 0 92.8 0 128v256c0 35.2 28.8 64 64 64h512c35.2 0 64-28.8 64-64V128C640 92.8 611.2 64 576 64zM64 296C64 291.6 67.63 288 72 288h16C92.38 288 96 291.6 96 296v16C96 316.4 92.38 320 88 320h-16C67.63 320 64 316.4 64 312V296zM336 384h-256C71.2 384 64 376.8 64 368C64 359.2 71.2 352 79.1 352h256c8.801 0 16 7.199 16 16C352 376.8 344.8 384 336 384zM128 312v-16C128 291.6 131.6 288 136 288h16C156.4 288 160 291.6 160 296v16C160 316.4 156.4 320 152 320h-16C131.6 320 128 316.4 128 312zM192 312v-16C192 291.6 195.6 288 200 288h16C220.4 288 224 291.6 224 296v16C224 316.4 220.4 320 216 320h-16C195.6 320 192 316.4 192 312zM256 312v-16C256 291.6 259.6 288 264 288h16C284.4 288 288 291.6 288 296v16C288 316.4 284.4 320 280 320h-16C259.6 320 256 316.4 256 312zM352 312C352 316.4 348.4 320 344 320h-16C323.6 320 320 316.4 320 312v-16C320 291.6 323.6 288 328 288h16C348.4 288 352 291.6 352 296V312zM352 237.7C352 247.9 344.4 256 334.9 256H81.07C71.6 256 64 247.9 64 237.7V146.3C64 136.1 71.6 128 81.07 128h253.9C344.4 128 352 136.1 352 146.3V237.7zM560 384h-160c-8.801 0-16-7.201-16-16c0-8.801 7.199-16 16-16h160c8.801 0 16 7.199 16 16C576 376.8 568.8 384 560 384z"/></svg>
          <span>Tacógrafos</span>
        </a>

        <a href="{{ route('fleet.dashboard.extinguisher') }}" class="{{ request()->is('*/extinguisher') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">
          <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" stroke="currentColor" stroke-width="2" class="{{ request()->is('*/extinguisher') ? 'text-blue-500' : 'text-gray-400 group-hover:text-gray-500' }} -ml-0.5 mr-2 h-5 w-5" viewBox="0 0 512 512">
            <path d="M64 480c0 17.67 14.33 32 31.1 32H256c17.67 0 31.1-14.33 31.1-32l-.0001-32H64L64 480zM503.4 5.56c-5.453-4.531-12.61-6.406-19.67-5.188l-175.1 32c-11.41 2.094-19.7 12.03-19.7 23.63L224 56L224 32c0-17.67-14.33-32-31.1-32H160C142.3 0 128 14.33 128 32l.0002 26.81C69.59 69.32 20.5 110.6 1.235 168.4C-2.952 181 3.845 194.6 16.41 198.8C18.94 199.6 21.48 200 24 200c10.05 0 19.42-6.344 22.77-16.41C59.45 145.5 90.47 117.8 128 108L128 139.2C90.27 157.2 64 195.4 64 240L64 416h223.1l.0001-176c0-44.6-26.27-82.79-63.1-100.8L224 104l63.1-.002c0 11.59 8.297 21.53 19.7 23.62l175.1 31.1c1.438 .25 2.875 .375 4.297 .375c5.578 0 11.03-1.938 15.37-5.562c5.469-4.562 8.625-11.31 8.625-18.44V23.1C511.1 16.87 508.8 10.12 503.4 5.56zM176 96C167.2 96 160 88.84 160 80S167.2 64 176 64s15.1 7.164 15.1 16S184.8 96 176 96z"/>
          </svg>
          <span>Extintores</span>
        </a>

      </nav>
    </div>
  </div>
</div>
