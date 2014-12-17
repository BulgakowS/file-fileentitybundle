FileEntityBundle
================

Simple way to upload files

## Installation:

Pretty simple with [Composer](http://packagist.org), add:

```json
{
    "require": {
        "brainx2/file-fileentitybundle": "1.0.0.*@dev"
    }
}
```

### Add PaginatorBundle to your application kernel

```php
// app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        new Brainx2\File\FileEntityBundle\Brainx2FileFileEntityBundle(),
        // ...
    );
}
```

## Usage examples:

### ORM.yml

```yaml
Demo\BackendBundle\Entity\Demo:
    type:  entity
    table: demo
    id:
        id:
            type: integer
            generator:
                strategy: AUTO
    fields:
        name:
            type: string
            length: 50
        image_first:
            type: string
            length: 255
            nullabel: true
        image_second:
            type: string
            length: 255
            nullabel: true
            
    lifecycleCallbacks:
        prePersist: [upload]
        preUpdate: [upload]
        preRemove: [remove]
```

### Entity
```php
namespace Demo\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Brainx2\File\FileEntityBundle\Entity\FileEntity as FileEntity;


/**
 * Demo
 */
class Demo extends FileEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    protected $image_first;

    /**
     * @var string
     */
    protected $image_second;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Demo
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set image_first
     *
     * @param string $imageFirst
     * @return Demo
     */
    public function setImageFirst($imageFirst)
    {
        if(!is_null($imageFirst)) {
            $this->setFiles('image_first');

            $this->image_first = $imageFirst;
        }

        return $this;
    }

    /**
     * Get image_first
     *
     * @return string 
     */
    public function getImageFirst()
    {
        return $this->image_first;
    }

    /**
     * Set image_second
     *
     * @param string $imageSecond
     * @return Demo
     */
    public function setImageSecond($imageSecond)
    {
        if(!is_null($imageSecond)) {
            $this->setFiles('image_second');

            $this->image_second = $imageSecond;
        }

        return $this;
    }

    /**
     * Get image_second
     *
     * @return string 
     */
    public function getImageSecond()
    {
        return $this->image_second;
    }
    
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function upload()
    {
        return parent::upload();
    }
    
    /**
     * @ORM\PreRemove
     */
    public function remove()
    {
        $this->setFiles('image_first');
        $this->setFiles('image_second');
        
        return parent::remove();
    }    
    
    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return '/uploads/files';
    } 
}
```

### View

```jinja
<img src="{{ entity.webpath('image_first') }}" alt="" />
<img src="{{ entity.webpath('image_second') }}" alt="" />
```