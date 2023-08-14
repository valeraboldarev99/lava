<?php

namespace App\Helpers;

use Session;

class MyForm
{
	static function open($attr)
	{
		if(isset($attr['entity']))
		{
			$entity = $attr['entity'];
			isset($attr['store']) ? $store = $attr['store'] : $store = '';
			$update = $attr['update'];
			$methodInput = '';

			Session::flash('entity', $entity);

			if(isset($entity->id))
			{
				$action = route($update, $entity->id);
				$methodInput = '<input type="hidden" name="_method" value="PATCH">';
			}
			else {
				$action = route($store);
			}
		}

		if(isset($attr['method']) && $attr['method'])
		{
			$method = $attr['method'];
		}
		else {
			$method = '';
		}

		if(isset($attr['autocomplete']) && $attr['autocomplete'])
		{
			$autocomplete = 'autocomplete="on"'; 
		}
		else {
			$autocomplete = '';
		}

		if(isset($attr['files']) && $attr['files']) 
		{
			$files = 'enctype="multipart/form-data"'; 
		}
		else {
			$files = '';
		}

		$csrf = '<input type="hidden" name="_token" value="' . csrf_token() . '">';

		if(isset($attr['entity']))
		{
			return '<form method="' . $method . '" action="' . $action . '" ' . $autocomplete . $files . '>' . 
						$csrf .
						$methodInput;
		}

		if(isset($attr['action']))
		{
			return '<form method="' . $method . '" action="' . $attr['action'] . '" ' . $autocomplete . $files . '>' . 
						$csrf;
		}
	}

	public function close()
	{
		return '</form>';
	}

	public function errors($name)
	{
		$errors = Session::get('errors');
		if (isset($errors) && $errors->has($name))
		{
			return '<div class="form-error">' . $errors->first($name) . '</div>';
		}
	}

	public function label($label, $name = null)
	{
		return '<label for="' . $name . '">' . $label . '</label>';
	}

	public function input($type, $name, $label = null, $value = null, $options = [])
	{
		old($name) ? $value = old($name) : $value = $value;

		if($type == 'range')
		{
			$input = '<input type="' . $type . '"
							id="' . $name . '"
							name="' . $name . '"
							value="' . $value . '" 
									' . implode($options, ' ') .'>';
		}
		elseif ($type == 'checkbox')
		{
			if($value == 1)
			{
				$options[] = 'checked="checked"';
			}
			$inputHidden = '<input type="hidden" name="' . $name . '" value="0" />';
			$input = $inputHidden .
						'<input type="' . $type . '"
							id="' . $name . '"
							class="form-control_checkbox"
							value="1"
							name="' . $name . '"
									' . implode($options, ' ') .'>';
		}
		else {
			$input = '<input type="' . $type . '"
							id="' . $name . '"
							class="form-control"
							name="' . $name . '"
							value="' . $value . '" 
									' . implode($options, ' ') .'>';
		}

		$label = $label != '' ? MyForm::label($label, $name) : '';
		$block = MyForm::block($label, $input, $name);
		return $block;
	}

	public function block($label, $field, $name = '')
	{
		$errors = MyForm::errors($name);
		$block = '<div class="form-group">' . $label . ' ' . $field . $errors . '</div>';
		return $block;
	}

	public function text($name, $label = null, $value = null, $options = [])
	{
		return MyForm::input('text', $name, $label, $value, $options);
	}

	public function password($name, $label = null, $value = null, $options = [])
	{
		return MyForm::input('password', $name, $label, $value, $options);
	}

	public function email($name, $label = null, $value = null, $options = [])
	{
		return MyForm::input('email', $name, $label, $value, $options);
	}

	public function tel($name, $label = null, $value = null, $options = [])
	{
		return MyForm::input('tel', $name, $label, $value, $options);
	}

	public function url($name, $label = null, $value = null, $options = [])
	{
		return MyForm::input('url', $name, $label, $value, $options);
	}

	public function number($name, $label = null, $value = null, $options = [])
	{
		return MyForm::input('number', $name, $label, $value, $options);
	}

	public function date($name, $label = null, $value = null, $options = [])
	{
		return MyForm::input('date', $name, $label, $value, $options);
	}

	public function time($name, $label = null, $value = null, $options = [])
	{
		return MyForm::input('time', $name, $label, $value, $options);
	}

	public function month($name, $label = null, $value = null, $options = [])
	{
		return MyForm::input('month', $name, $label, $value, $options);
	}

	public function week($name, $label = null, $value = null, $options = [])
	{
		return MyForm::input('week', $name, $label, $value, $options);
	}

	public function color($name, $label = null, $value = null, $options = [])
	{
		return MyForm::input('color', $name, $label, $value, $options);
	}

	public function file($name, $label = null, $value = null, $options = [])
	{
		return MyForm::input('file', $name, $label, $value, $options);
	}

	public function range($name, $label = null, $value = null, $options = [])
	{
		return MyForm::input('range', $name, $label, $value, $options);
	}

	public function checkbox($name, $label = null, $value = null, $options = [])
	{
		return MyForm::input('checkbox', $name, $label, $value, $options);
	}

	public function radio($name, $label = null, $values = [], $style = 'stacked')
	{
		$labelBlock = MyForm::label($label, $name);
		$radioBlock = [];
		$entity = session('entity');
		$selectedItem = $entity->$name;
		old($name) ? $selectedItem = old($name) : $selectedItem = $selectedItem;

		$style == 'stacked' ? $styleBlock = 'form-check' : $styleBlock = 'form-check form-check-inline';
		$style == 'inline' ? $styleFormBlock = ' form-group_block' : $styleFormBlock = '';

		foreach($values as $value => $text)
		{
			$selectedItem == $value ? $checked = 'checked' : $checked = '';

			$label = '<label class="form-check-label" for="' . $value . '">' . $text . '</label>';

			$input = '<input type="radio"
							id="' . $value . '"
							class="form-check-input"
							name="' . $name . '"
							value="' . $value . '"
							' . $checked . '>';

			$radioBlock[] = '<div class="' . $styleBlock . '">' . $input . ' ' . $label . '</div>';
		}

		$errors = MyForm::errors($name);
		$block = '<div class="form-group' . $styleFormBlock . '">' . $labelBlock . ' ' . implode($radioBlock, ' ') . $errors . '</div>';

		return $block;
	}

	public function hidden($name, $value = null, $options = [])
	{
		// return MyForm::input('hidden', $name, $label = null, $value, $options);
		return $input = '<input type="hidden"
							id="' . $name . '"
							name="' . $name . '"
							value="' . $value . '"
									' . implode($options, ' ') .'>';
	}

	public function button($type, $name, $options = [])
	{
		return '<button 
					type="' . $type . '" ' 
							. implode($options, ' ') . '>'
							. $name . '</button>';
	}

	public function submit($name)
	{
		$options[] = 'class="btn btn-success"';

		return MyForm::button('submit', $name, $options);
	}

	public function reset($name)
	{
		$options[] = 'class="btn btn-warning"';

		return MyForm::button('reset', $name, $options);
	}

	public function select($name, $label = null, $value, $options = [])
	{
		$entity = session('entity');
		$selectedItem = $entity->$name;
		old($name) ? $selectedItem = old($name) : $selectedItem = $selectedItem;

		$label = MyForm::label($label, $name);
		$options_all = [];
		foreach($value as $key => $item)
		{
			$key == $selectedItem ? $selected = 'selected="selected"' : $selected = '';

			$options_all[] = '<option value="' . $key . '" ' . $selected . '>' 
								. $item
							. '</option>';
		}

		$select = '<select class="form-control" 
								id="' . $name . '" 
								name="' . $name . '" '
								. implode($options, ' ') . '>'
						. implode($options_all, ' ') 
					. '</select>';

		$block = MyForm::block($label, $select, $name);
		return $block;
	}

	public function textarea($name, $label = null, $value = [], $options = [])
	{
		old($name) ? $value = old($name) : $value = $value;

		$label = MyForm::label($label, $name);
		$textarea = '<textarea class="form-control"
								id="' . $name . '"
								name="' . $name . '"
								' . implode($options, ' ') . '>' . $value . '</textarea>';
		$block = MyForm::block($label, $textarea, $name);
		return $block;
	}

	public function helpText($text)
	{
		return '<p class="help__block">' . $text . '</p>';
	}

	public function simpleText($text, $label = null)
	{
		$label = MyForm::label($label);
		$text = '<p class="k">' . $text . '</p>';
		$block = MyForm::block($label, $text);

		return $block;
	}

// Form
	// {!! MyForm::open([
	//     'entity' => $entity,
	//     'method' => 'POST',
	//     'store' => $routePrefix . 'store',
	//     'update' => $routePrefix . 'update',
	//     'autocomplete' => true,
	//     'files' => true]) !!}

	// {!! MyForm::close() !!}

// Inputs
	// {!! MyForm::input('type', 'input_name', 'label text' , $value, ['other attr']) !!}
	// {!! MyForm::text('input_name', 'name' , $entity->name) !!}
	// {!! MyForm::password('input_name', 'PASSWORD_LABEL' , $entity->password) !!}
	// {!! MyForm::date('input_name', 'DATE_LABEL' , $entity->date) !!}
	// {!! MyForm::email('input_name', 'EMAIL_LABEL' , $entity->email) !!}
	// {!! MyForm::color('input_name', 'COLOR_LABEL' , $entity->color) !!}
	// {!! MyForm::file('input_name', 'FILE_LABEL' , $entity->file) !!}
	// {!! MyForm::number('input_name', 'NUMBER_LABEL' , $entity->number) !!}
	// {!! MyForm::tel('input_name', 'TEL_LABEL' , $entity->tel) !!}
	// {!! MyForm::url('input_name', 'URL_LABEL' , $entity->url) !!}
	// {!! MyForm::time('input_name', 'TIME_LABEL' , $entity->time) !!}
	// {!! MyForm::week('input_name', 'WEEK_LABEL' , $entity->week) !!}
	// {!! MyForm::month('input_name', 'MONTH_LABEL' , $entity->month) !!}
	// {!! MyForm::range('input_name', 'RANGE_LABEL' , $entity->range, ['min="0"', 'max="10"']) !!}
	// {!! MyForm::textarea('input_name', 'Описание', $entity->textarea, ['rows="5"']) !!}

	// {!! MyForm::checkbox('checkbox_name', 'CHECKBOX_LABEL' , $value) !!}
	// {!! MyForm::radio('radio_name', 'radio_label', [
	//          'value1' => 'text1',
	//          'value2' => 'text2',
	//          'value3' => 'text3',
	//      ], 'inline') !!} {{-- 'stacked', 'inline' --}}

// Buttons
	// {!! MyForm::button('reset','Имя', ['class="btn btn-danger"']) !!}
	// {!! MyForm::submit('Save') !!}
	// {!! MyForm::reset('Reset') !!}

// Select
	// {!! MyForm::select('select_name', 'SELECT_LABEL', $entity->getType()) !!}  For correct operation in entity there must be a field the same as the field name

	// {!! MyForm::helpText('text under input') !!}
	// {!! MyForm::simpleText('same text', 'TEXT_LABEL') !!}
    // {!!  MyForm::hidden($name, $value, $options = []) !!}
}