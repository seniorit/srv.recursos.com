---
name: create-skill
description: "Create a reusable workspace skill (SKILL.md) that captures a repeatable workflow and helps build agent customization skills."
user-invocable: true
argument-hint: "Describe the workflow or task the new skill should support."
---

Use this skill when you need to create, update, or finalize a reusable `SKILL.md` for this repository.

## Workflow

1. Review the current conversation and repository context.
    - Identify the task, existing patterns, and any prior workflow steps.
    - If the user has a multi-step process, extract the key phases and decision points.

2. Clarify the outcome if needed.
    - Ask whether the skill should be workspace-scoped or personal.
    - Ask whether the skill should be a quick checklist or a complete multi-step workflow.
    - Confirm the target file path and any naming conventions.

3. Draft the skill.
    - Choose a clear name and description that matches the workflow.
    - Add frontmatter with `name`, `description`, `user-invocable`, and `argument-hint`.
    - Write a step-by-step process including:
        - when to use the skill
        - branching logic or decision points
        - quality criteria and completion checks

4. Validate the draft.
    - Ensure the skill file path is correct: `.github/skills/<skill-name>/SKILL.md`.
    - Verify YAML frontmatter syntax and quoting.
    - Confirm the description is discoverable and contains key trigger phrases.
    - Keep the content concise and actionable.

5. Summarize the result.
    - Explain what the skill produces.
    - Mention the file path.
    - Suggest example prompts to invoke it.

## Quality criteria

- Use plain language and minimal ambiguity.
- Keep the workflow aligned with repository conventions.
- Do not invent unrelated file types or locations.
- Preserve existing patterns for `.github` customizations.

## Example prompts

- "Create a skill to scaffold model/controller/update workflows for Laravel payroll features."
- "Generate a SKILL.md for handling database migration review in this repo."
- "Help me build a reusable skill for API endpoint design and validation."
