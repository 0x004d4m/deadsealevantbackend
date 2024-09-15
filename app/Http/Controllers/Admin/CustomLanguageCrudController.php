<?php

namespace App\Http\Controllers\Admin;

use Backpack\LangFileManager\app\Http\Controllers\LanguageCrudController as BaseLanguageCrudController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class CustomLanguageCrudController extends BaseLanguageCrudController
{
    public function store()
    {
        $response = parent::store();
        $newLocale = $this->crud->entry->abbr;
        $newName = $this->crud->entry->name;
        $this->updateLocalesConfig($newLocale, $newName);
        $this->copyLanguageFiles($newLocale);
        return $response;
    }

    public function update()
    {
        $existingLocale = $this->crud->getCurrentEntry()->abbr;
        $existingName = $this->crud->getCurrentEntry()->name;

        $response = parent::update();

        $newLocale = $this->crud->entry->abbr;
        $newName = $this->crud->entry->name;

        if ($response) {
            if ($existingLocale !== $newLocale || $existingName !== $newName) {
                $this->updateLanguageFolder($existingLocale, $newLocale);
                $this->updateLocalesConfig($newLocale, $newName, $existingLocale);
            }
        }

        return $response;
    }

    public function destroy($id)
    {
        $language = $this->crud->getEntry($id);
        $locale = $language->abbr;

        $response = parent::destroy($id);

        if ($response) {
            $this->deleteLanguageFolder($locale);
            $this->removeLocaleFromConfig($locale);
        }

        return $response;
    }

    protected function updateLanguageFolder($oldLocale, $newLocale)
    {
        $langPath = lang_path();
        $oldPath = $langPath . '/' . $oldLocale;
        $newPath = $langPath . '/' . $newLocale;

        if (File::exists($oldPath)) {
            if ($oldLocale !== $newLocale) {
                File::move($oldPath, $newPath);
            }
        } else {
            Log::warning("Old language folder '{$oldLocale}' not found at {$oldPath}.");
        }
    }

    protected function updateLocalesConfig($newLocale, $newName, $oldLocale = null)
    {
        $configPath = config_path('backpack/crud.php');
        $config = Config::get('backpack.crud');

        if ($oldLocale && isset($config['locales'][$oldLocale])) {
            unset($config['locales'][$oldLocale]);
        }

        $config['locales'][$newLocale] = $newName;
        $configContent = "<?php\n\nreturn " . var_export($config, true) . ";\n";
        File::put($configPath, $configContent);
    }

    protected function copyLanguageFiles($newLocale)
    {
        $langPath = lang_path();
        $defaultLocalePath = $langPath . '/en';
        $destinationPath = $langPath . '/' . $newLocale;

        if (File::exists($defaultLocalePath)) {
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $files = File::allFiles($defaultLocalePath);
            $directories = File::directories($defaultLocalePath);

            foreach ($files as $file) {
                $destinationFilePath = $destinationPath . '/' . $file->getFilename();
                File::copy($file->getPathname(), $destinationFilePath);
            }

            foreach ($directories as $directory) {
                $destinationDirectoryPath = $destinationPath . '/' . basename($directory);
                File::copyDirectory($directory, $destinationDirectoryPath);
            }
        } else {
            Log::error("Default 'en' language folder not found.");
        }
    }

    protected function deleteLanguageFolder($locale)
    {
        $langPath = lang_path($locale);

        if (File::exists($langPath)) {
            File::deleteDirectory($langPath);
        } else {
            Log::warning("Language folder '{$locale}' not found at {$langPath}.");
        }
    }

    protected function removeLocaleFromConfig($locale)
    {
        $configPath = config_path('backpack/crud.php');
        $config = Config::get('backpack.crud');

        if (isset($config['locales'][$locale])) {
            unset($config['locales'][$locale]);

            $configContent = "<?php\n\nreturn " . var_export($config, true) . ";\n";
            File::put($configPath, $configContent);
        }
    }
    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }
}
