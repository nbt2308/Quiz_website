export default async function typeText(
  t: TestController,
  textField: Selector,
  value: string,
  inputType: "input" | "textarea" = "input",
  clearBeforeType: boolean = false,
  isPasteText: boolean = false
) {
  await t.click(textField);

  const tagName = await textField.tagName;
  const input = tagName === inputType ? textField : textField.find(inputType);

  if (clearBeforeType) {
    await t.click(input).pressKey("ctrl+a").pressKey("delete");
  }
  await t.typeText(input, value, { paste: isPasteText });
}