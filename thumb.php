<?php
use Thumb as Generator;

class Superthumbs extends Kirby\Component\Thumb {
      public function create($file, $params) {
        
        if(!$file->isWebsafe()) {
          return $file;
        }
    
        // load a thumb preset
        $presets = $this->kirby->option('thumbs.presets');
        if(is_string($params)) {
          if(isset($presets[$params])) {
            $params = $presets[$params];
          } else {
            throw new Error('Invalid thumb preset ' . $params);
          }
        } else if($params === []) {
          // try to load the default preset
          // otherwise use the thumb defaults from the Toolkit
          if(isset($presets['default'])) {
            $params = $presets['default'];
          }
        }
    
        // generate the thumb
        $thumb = new Generator($file, $params);
        $asset = new Asset($thumb->result);

        // Convert to jpg if png
        $asset = $this->convert($asset, $params);
    
        // store a reference to the original file
        $asset->original($file);
    
        return $thumb->exists() ? $asset : $file;
    
      }

      // Convert to jpg if the param or config format is jpg
      public function convert($asset, $params) {
        $format = false;
        if(isset($params['format'])) {
          if($params['format'] == 'jpg') {
            $format = true;
          }
        } elseif(c::get('thumbs.format') == 'jpg') {
          $format = true;
        }
        if($format) {
          $asset = $this->format($asset, $params);
        }
        return $asset;
      }

      // Take care of quality, paths and return a new asset object
      public function format($asset, $params) {
        $output_path = $asset->dir() . DS . $asset->name() . '.jpg';
        

        if($asset->extension() == 'png' && ! file_exists($output_path)) {
          $quality = (isset($params['quality'])) ? $params['quality'] : generator::$defaults['quality'];
          $result = $this->pngtojpg($asset->root(), $output_path, $quality);
        }

        if(file_exists($output_path)) {
          $output_url = str_replace([kirby()->roots()->index() . DS, DS], ['', '/'], $output_path);
          $asset = new Asset($output_url);
        }

        return $asset;
      }

      // Convert the jpg to png
      public function pngtojpg($filePath, $output, $quality) {
        $image = imagecreatefrompng($filePath);
        $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
        imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
        imagealphablending($bg, TRUE);
        imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
        imagedestroy($image);
        $result = imagejpeg($bg, $output, $quality);
        imagedestroy($bg);
        return $result;
      }
  }