<?php

namespace ElGigi\SystemPay;

/**
 * Class AbstractObject.
 *
 * @package ElGigi\SystemPay
 */
abstract class AbstractObject
{
    /** @var array Data declaration */
    private $dataDeclaration = [];
    /** @var array Data values */
    private $data = [];

    /**
     * AbstractObject constructor.
     *
     * @param string[] $dataDeclaration Array of variables (example: ['reference': 'n..80', 'title' =>
     *                                  '[PRIVATE,COMPANY]'])
     * @param array    $data            Default data
     */
    public function __construct(array $dataDeclaration, array $data = [])
    {
        $this->dataDeclaration = $dataDeclaration;

        // Set default data
        $this->setData($data);
    }

    /**
     * __set_state() magic method.
     *
     * @return array
     */
    public function __set_state(): array
    {
        $vars = [];

        foreach ($this->data as $key => $value) {
            if ($value instanceof AbstractObject) {
                $vars[$key] = $value->__set_state();
            } else {
                $vars[$key] = $value;
            }
        }

        return $vars;
    }

    /**
     * __debugInfo() magic method.
     *
     * @return array
     */
    public function __debugInfo(): array
    {
        $vars = [];

        foreach ($this->dataDeclaration as $key => $type) {
            if (array_key_exists($key, $this->data)) {
                if ($this->data[$key] instanceof AbstractObject) {
                    $vars[$key] = $this->data[$key]->__set_state();
                } else {
                    $vars[$key] = $this->data[$key];
                }
            } else {
                $vars[$key] = null;
            }
        }

        return $vars;
    }

    /**
     * __get() magic method.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get(string $name)
    {
        if (array_key_exists($name, $this->dataDeclaration)) {
            if (array_key_exists($name, $this->data)) {
                return $this->data[$name];
            } else {
                return null;
            }
        } else {
            trigger_error('Undefined variable "' . $name . '" in class "' . get_class($this) . '"', E_USER_WARNING);
        }

        return null;
    }

    /**
     * __set() magic method.
     *
     * @param string $name
     * @param mixed  $value
     */
    public function __set(string $name, $value)
    {
        if (array_key_exists($name, $this->dataDeclaration)) {
            if ($this::controlFormat($this->dataDeclaration[$name], $value)) {
                $this->data[$name] = $value;
            } else {
                trigger_error('Bad format for property "' . $name . '" (' . $this->dataDeclaration[$name] . ') in class "' . get_class($this) . '", ' . (is_object($value) ? get_class($value) : '"' . $value . '"') . ' given.');
            }
        } else {
            trigger_error('Undefined property "' . $name . '" in class "' . get_class($this) . '", or readonly.');
        }
    }

    /**
     * Set data.
     *
     * @param array $data
     *
     * @return \ElGigi\SystemPay\AbstractObject
     */
    public function setData(array $data): AbstractObject
    {
        foreach ($data as $name => $value) {
            $this->__set($name, $value);
        }

        return $this;
    }

    /**
     * Control format.
     *
     * @param string        $type  Type of variable
     * @param string|object $value Value to control
     *
     * @return bool
     */
    public static function controlFormat(string $type, $value): bool
    {
        $bReturn = false;

        if (is_object($value)) {
            $bReturn = is_subclass_of($type, __CLASS__) && is_a($value, $type);
        } else {
            if ($type == 'bool') {
                $bReturn = is_bool($value);
            } else {
                if ($type == 'datetime') {
                    $bReturn = preg_match('/([0-2][0-9]{3})\-([0-1][0-9])\-([0-3][0-9])T([0-5][0-9])\:([0-5][0-9])\:([0-5][0-9])(Z|([\-\+]([0-1][0-9])\:00))/', $value) == 1;
                } else {
                    if ($type == 'int') {
                        $bReturn = is_int($value);
                    } else {
                        if ($type == 'long') {
                            $bReturn = is_long($value);
                        } else {
                            if ($type == 'string') {
                                $bReturn = is_string($value);
                            } else {
                                $match = [];
                                if (preg_match('/^([ans]{1,3})((\.\.)?([0-9]+))$/i', $type, $match)) {
                                    $regexControl = '[' .
                                                    (stripos($match[1], 'a') !== false ? 'a-z' : '') .
                                                    (stripos($match[1], 'n') !== false ? '0-9' : '') .
                                                    (stripos($match[1], 's') !== false ? '\V' : '') .
                                                    ']' .
                                                    '{' .
                                                    (isset($match[3]) ? '1,' : '') .
                                                    $match[4] .
                                                    '}';

                                    $bReturn = preg_match('/^' . $regexControl . '$/i', $value) == 1;
                                } else {
                                    if (preg_match('/^\[(.*)\]/', $type, $match)) {
                                        $bReturn = in_array($value, array_map('trim', explode(',', $match[1])));
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $bReturn;
    }
}